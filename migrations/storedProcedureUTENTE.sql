USE BOSTARTER;

-- Autenticazione/registrazione sulla piattaforma
DROP PROCEDURE IF EXISTS inserisciUtente;
DELIMITER @@
CREATE PROCEDURE inserisciUtente (
    IN Mail VARCHAR(30), 
    IN PasswordUtente VARCHAR(30),
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
    IN EmailUtente VARCHAR(30), 
    IN PasswordUtente VARCHAR(30), 
    OUT esito SMALLINT
)
BEGIN
    -- Controlla se esiste un utente con le credenziali fornite
    SELECT COUNT(*) INTO esito 
    FROM UTENTE 
    WHERE Email = EmailUtente AND Password = PasswordUtente;
END @@
DELIMITER ;

-- Inserimento delle proprie skill di curriculum
DROP PROCEDURE IF EXISTS inserisciSkillCurriculum;
DELIMITER @@
CREATE PROCEDURE inserisciSkillCurriculum (
    IN Mail VARCHAR(30), 
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
DROP PROCEDURE IF EXISTS visualizzaProgetti;
DELIMITER @@
CREATE PROCEDURE visualizzaProgetti (IN Mail VARCHAR(30))
BEGIN
    SELECT * FROM PROGETTO WHERE Email_Creatore = Mail;
END @@
DELIMITER ;

-- Finanziamento di un progetto aperto
DROP PROCEDURE IF EXISTS finanziaProgetto;
DELIMITER @@
CREATE PROCEDURE finanziaProgetto (
    IN EmailUtente VARCHAR(30), 
    IN NomeProgetto VARCHAR(30), 
    IN ImportoUtente DOUBLE, 
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
    IN EmailUtente VARCHAR(30), 
    IN NomeProgetto VARCHAR(30), 
    IN Testo VARCHAR(1000), 
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
    IN EmailUtente VARCHAR(30), 
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
CREATE PROCEDURE inserisciCandidatura (IN EmailUtente VARCHAR(30), IN NomeProgetto VARCHAR(30))
BEGIN
    DECLARE progettoEsistente INT DEFAULT 0;

    -- Controllo se il progetto esiste
    SELECT COUNT(*) INTO progettoEsistente FROM PROGETTO WHERE Nome = NomeProgetto;

    -- Se il progetto esiste, inseriamo la candidatura
    IF progettoEsistente > 0 THEN
        START TRANSACTION;
        INSERT INTO CANDIDATURA (Email_Utente, Nome_Progetto) VALUES (EmailUtente, NomeProgetto);
        COMMIT;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Il progetto non esiste.';
    END IF;
END @@
DELIMITER ;
