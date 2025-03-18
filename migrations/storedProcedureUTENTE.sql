USE BOSTARTER;

-- Autenticazione/registrazione sulla piattaforma
DROP PROCEDURE IF EXISTS inserisciUtente;
DELIMITER @@
CREATE PROCEDURE inserisciUtente (
    IN Mail VARCHAR(50), 
    IN PasswordUtente VARCHAR(60),
    IN AnnoNascita SMALLINT, 
    IN CognomeUtente VARCHAR(30), 
    IN NomeUtente VARCHAR(30), 
    IN LuogoNascita VARCHAR(30), 
    IN NicknameUtente VARCHAR(30)
)     
BEGIN
    START TRANSACTION;
    INSERT INTO UTENTE (Email, Password, Anno_Nascita, Cognome, Nome, Luogo_Nascita, Nickname)
    VALUES (Mail, PasswordUtente, AnnoNascita, CognomeUtente, NomeUtente, LuogoNascita, NicknameUtente);
    COMMIT;
END @@
DELIMITER ;

-- Autenticazione utente
DROP PROCEDURE IF EXISTS autenticaUtente;
DELIMITER @@
CREATE PROCEDURE autenticaUtente (
    IN EmailUtente VARCHAR(50)
)
BEGIN
    SELECT Password, Email, Nome, Cognome, Nickname
    FROM UTENTE 
    WHERE Email = EmailUtente;
END @@
DELIMITER ;

-- Inserimento delle proprie skill di curriculum
DROP PROCEDURE IF EXISTS inserisciSkillCurriculum;
DELIMITER @@
CREATE PROCEDURE inserisciSkillCurriculum (
    IN Mail VARCHAR(50), 
    IN NomeCompetenza VARCHAR(30), 
    IN Livello VARCHAR(30)
)
BEGIN
    START TRANSACTION;
    INSERT INTO SKILL_CURRICULUM (Email_Utente, Nome_Competenza, Livello)
    VALUES (Mail, NomeCompetenza, Livello);
    COMMIT;
END @@
DELIMITER ;

-- Visualizzazione dei progetti disponibili
DROP PROCEDURE IF EXISTS visualizzaProgettiConFoto;
DELIMITER @@
CREATE PROCEDURE visualizzaProgettiConFoto ()
BEGIN
    SELECT P.*, SUM(FN.Importo) AS Totale_Finanziamenti, F.Codice_Foto
    FROM PROGETTO P
    LEFT JOIN FINANZIAMENTO FN ON P.Nome = FN.Nome_Progetto
    LEFT JOIN FOTO F ON P.Nome = F.Nome_Progetto
    WHERE P.Stato = 'Aperto'
    GROUP BY P.Nome, F.Codice_Foto;
END @@
DELIMITER ;

-- Finanziamento di un progetto aperto
DROP PROCEDURE IF EXISTS finanziaProgetto;
DELIMITER @@
CREATE PROCEDURE finanziaProgetto (
    IN EmailUtente VARCHAR(50), 
    IN NomeProgetto VARCHAR(30), 
    IN ImportoUtente FLOAT, 
    IN DataFinanziamento DATE, 
    IN CodiceReward INT
)
BEGIN
    DECLARE statoProgetto VARCHAR(10);

    -- Controllo se il progetto esiste e prendiamo lo stato
    SELECT Stato INTO statoProgetto FROM PROGETTO WHERE Nome = NomeProgetto;

    -- Se il progetto è aperto, inseriamo il finanziamento
    IF statoProgetto = 'Aperto' THEN
        START TRANSACTION;
        INSERT INTO FINANZIAMENTO (Email_Utente, Nome_Progetto, Importo, Data, Codice_Reward)
        VALUES (EmailUtente, NomeProgetto, ImportoUtente, DataFinanziamento, CodiceReward);
        COMMIT;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Il progetto non è aperto ai finanziamenti.';
    END IF;
END @@
DELIMITER ;

-- Inserimento di un commento relativo a un progetto
DROP PROCEDURE IF EXISTS inserisciCommentoProgetto;
DELIMITER @@
CREATE PROCEDURE inserisciCommentoProgetto (
    IN EmailUtente VARCHAR(50), 
    IN NomeProgetto VARCHAR(30), 
    IN Testo VARCHAR(350), 
    IN DataCommento DATE
)
BEGIN
    DECLARE progettoEsistente INT DEFAULT 0;

    -- Controllo se il progetto esiste
    SELECT COUNT(*) INTO progettoEsistente FROM PROGETTO WHERE Nome = NomeProgetto;

    -- Se il progetto esiste, inseriamo il commento
    IF progettoEsistente > 0 THEN
        START TRANSACTION;
        INSERT INTO COMMENTO_PROGETTO (Email_Utente, Nome_Progetto, Testo, Data)
        VALUES (EmailUtente, NomeProgetto, Testo, DataCommento);
        COMMIT;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Il progetto non esiste.';
    END IF;
END @@
DELIMITER ;

-- Assegnazione di una reward
DROP PROCEDURE IF EXISTS assegnaReward;
DELIMITER @@
CREATE PROCEDURE assegnaReward (
    IN EmailUtente VARCHAR(50), 
    IN NomeProgetto VARCHAR(30), 
    IN CodiceReward INT
)
BEGIN
    DECLARE esisteFinanziamento INT DEFAULT 0;
    DECLARE rewardValida INT DEFAULT 0;

    -- Controlla se esiste un finanziamento
    SELECT COUNT(*) INTO esisteFinanziamento 
    FROM FINANZIAMENTO 
    WHERE Email_Utente = EmailUtente AND Nome_Progetto = NomeProgetto;

    IF esisteFinanziamento = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Nessun finanziamento trovato.';
    END IF;

    -- Controlla se la reward è valida
    SELECT COUNT(*) INTO rewardValida 
    FROM REWARD 
    WHERE Codice = CodiceReward AND Nome_Progetto = NomeProgetto;

    IF rewardValida = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Reward non valida.';
    END IF;

    -- Aggiorna il finanziamento
    UPDATE FINANZIAMENTO
    SET Codice_Reward = CodiceReward
    WHERE Email_Utente = EmailUtente AND Nome_Progetto = NomeProgetto;
END @@
DELIMITER ;

-- Inserimento di una candidatura
DROP PROCEDURE IF EXISTS inserisciCandidatura;
DELIMITER @@
CREATE PROCEDURE inserisciCandidatura (IN EmailUtente VARCHAR(50), IN NomeProgetto VARCHAR(30), IN NomeProfilo VARCHAR(30))
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
        INSERT INTO CANDIDATURA(Email_Utente, Nome_Profilo, Nome_Progetto, Stato)
        VALUES (EmailUtente, NomeProfilo, NomeProgetto, 'In Attesa');
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Errore: La candidatura non è valida';
    END IF;

    COMMIT;

END @@
DELIMITER ;

-- Visualizzazione delle skill di un utente
DROP PROCEDURE IF EXISTS ottieniSkillUtente;
DELIMITER @@
CREATE PROCEDURE ottieniSkillUtente (IN EmailUtente VARCHAR(50))
BEGIN

    SELECT Nome_Competenza, Livello
    FROM SKILL_CURRICULUM
    WHERE Email_Utente = EmailUtente;

END @@
DELIMITER ;

-- Visualizzazione delle skill di un utente
DROP PROCEDURE IF EXISTS ottieniCompetenze;
DELIMITER @@
CREATE PROCEDURE ottieniCompetenze ()
BEGIN

    SELECT Nome
    FROM COMPETENZA;
    
END @@
DELIMITER ;