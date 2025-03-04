USE BOSTARTER;

-- Inserimento di un nuovo progetto
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Progetto;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_Progetto(
    IN Nome_Progetto VARCHAR(20), 
    IN Descrizione_Progetto VARCHAR(50), 
    IN Data_Inserimento_Progetto DATE, 
    IN Data_Limite_Progetto DATE, 
    IN Budget_Progetto FLOAT, 
    IN Stato_Progetto VARCHAR(10), -- ENUM NON CONSENTITO
    IN Email_Creatore_Progetto VARCHAR(30)
)
BEGIN
    START TRANSACTION;
    INSERT INTO PROGETTO(Nome, Descrizione, Data_Inserimento, Data_Limite, Budget, Stato, Email_Creatore)
    VALUES (Nome_Progetto, Descrizione_Progetto, Data_Inserimento_Progetto, Data_Limite_Progetto, Budget_Progetto, Stato_Progetto, Email_Creatore_Progetto);
    COMMIT;
END @@
DELIMITER ;

-- Inserimento delle reward per un progetto
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Reward;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_Reward(
    IN Codice_Reward INT, 
    IN Descrizione_Reward VARCHAR(50), 
    IN Foto_Reward LONGBLOB, 
    IN Nome_Progetto VARCHAR(20)
)
BEGIN
    START TRANSACTION;
    INSERT INTO REWARD(Codice, Descrizione, Foto, Nome_Progetto) 
    VALUES (Codice_Reward, Descrizione_Reward, Foto_Reward, Nome_Progetto);
    COMMIT;
END @@
DELIMITER ;

-- Inserimento di una risposta a un commento
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Risposta;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_Risposta(
    IN ID_Commento_Risposta INT, 
    IN Testo_Risposta VARCHAR(200), 
    IN Email_Creatore_Risposta VARCHAR(30)
)
BEGIN
    START TRANSACTION;
    INSERT INTO RISPOSTA(ID_Commento, Testo, Email_Creatore)
    VALUES (ID_Commento_Risposta, Testo_Risposta, Email_Creatore_Risposta);
    COMMIT;
END @@
DELIMITER ;

-- Inserimento di un profilo per un progetto software
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Profilo;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_Profilo(
    IN Nome_ProgettoS VARCHAR(20), 
    IN Nome_ProfiloS VARCHAR(20)
)
BEGIN
    START TRANSACTION;
    IF EXISTS (SELECT 1 FROM PROGETTO WHERE Nome = Nome_ProgettoS) THEN
        IF EXISTS (SELECT 1 FROM PROFILO WHERE Nome = Nome_ProfiloS) THEN
            INSERT INTO COINVOLGIMENTO(Nome_Progetto, Nome_Profilo)
            VALUES (Nome_ProgettoS, Nome_ProfiloS);
        ELSE
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Errore: Il profilo non esiste';
        END IF;
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Errore: Il progetto non esiste';
    END IF;
    COMMIT;
END @@
DELIMITER ;

-- Accettazione di una candidatura
DROP PROCEDURE IF EXISTS Creatore_Accettazione_Candidatura;
DELIMITER @@
CREATE PROCEDURE Creatore_Accettazione_Candidatura(
    IN Email_Utente_Accettazione VARCHAR(30), 
    IN Nome_Profilo_Accettazione VARCHAR(20)
)
BEGIN
    DECLARE Nome_Competenza_Richiesta VARCHAR(50);
    DECLARE Livello_Competenza_Richiesta INT;
    DECLARE Nome_Competenza_Utente VARCHAR(50);
    DECLARE Livello_Competenza_Utente INT;
    DECLARE candidatura_valida BOOLEAN DEFAULT TRUE;
    DECLARE fine_cursor INT DEFAULT 0;

    DECLARE cursore_skillRichiesta CURSOR FOR 
    SELECT Nome_Competenza, Livello FROM SKILL_RICHIESTE WHERE Nome_Profilo = Nome_Profilo_Accettazione;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET fine_cursor = 1;

    START TRANSACTION;

    OPEN cursore_skillRichiesta;

    lettura_candidature: LOOP 
        FETCH cursore_skillRichiesta INTO Nome_Competenza_Richiesta, Livello_Competenza_Richiesta;

        IF fine_cursor THEN 
            LEAVE lettura_candidature;
        END IF;

        -- Controllo che l'utente abbia la competenza richiesta
        SET fine_cursor = 0;
        SELECT Nome_Competenza, Livello INTO Nome_Competenza_Utente, Livello_Competenza_Utente
        FROM SKILL_CURRICULUM 
        WHERE Email_Utente = Email_Utente_Accettazione 
        AND Nome_Competenza = Nome_Competenza_Richiesta 
        AND Livello >= Livello_Competenza_Richiesta
        LIMIT 1;

        -- Se non ha la competenza richiesta, esce dal loop
        IF Nome_Competenza_Utente IS NULL THEN
            SET candidatura_valida = FALSE;
            LEAVE lettura_candidature;
        END IF;
    END LOOP;

    CLOSE cursore_skillRichiesta;

    -- Se la candidatura è valida, la inserisce
    IF candidatura_valida = TRUE THEN
        INSERT INTO CANDIDATURA(Email_Utente, Nome_Profilo)
        VALUES (Email_Utente_Accettazione, Nome_Profilo_Accettazione);
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Errore: La candidatura non è valida';
    END IF;

    COMMIT;
END @@
DELIMITER ;
