USE BOSTARTER;

-- Autenticazione/registrazione sulla piattaforma
DROP PROCEDURE IF EXISTS inserisciUtente;
DELIMITER @
CREATE PROCEDURE inserisciUtente (IN Mail VARCHAR(30), IN Password VARCHAR(30),
                                 IN Anno_Nascita VARCHAR(30), IN Cognome VARCHAR(30), 
                                 IN Nome VARCHAR(30), IN Luogo, IN Nickname VARCHAR(30))     
BEGIN
START TRANSACTION;
    INSERT INTO UTENTE (Email, Password, Anno_Nascita, Cognome, Nome, Luogo, Nickname)
    VALUES (Mail, Password, Anno_Nascita, Cognome, Nome, Luogo, Nickname);
COMMIT;
END
@ DELIMITER;

DROP PROCEDURE IF EXISTS autenticaUtente;
DELIMITER @
CREATE PROCEDURE autenticaUtente (IN EmailUtente VARCHAR(30), IN PasswordUtente VARCHAR(30), OUT esito SMALLINT)
BEGIN
    -- Controlla se esiste un utente con le credenziali fornite
    SELECT COUNT(*) INTO esito 
    FROM UTENTE 
    WHERE Email = EmailUtente AND Password = PasswordUtente;
END 
@ DELIMITER;

-- Inserimento delle proprie skill di curriculum
DROP PROCEDURE IF EXISTS inserisciSkillCurriculum;
DELIMITER @
CREATE PROCEDURE inserisciSkillCurriculum (IN Mail VARCHAR(30), IN NomeCompetenza VARCHAR(30), IN Livello VARCHAR(30))
BEGIN
START TRANSACTION;
    INSERT INTO SKILL_CURRICULUM (Email_Utente, Nome_Competenza, Livello)
    VALUES (Mail, NomeCompetenza, Livello);
COMMIT;
END     
@ DELIMITER;

-- Visualizzazione dei progetti disponibili
DROP PROCEDURE IF EXISTS visualizzaProgetti;
DELIMITER @
CREATE PROCEDURE visualizzaProgetti (IN Mail VARCHAR(30))
BEGIN
    SELECT *
    FROM PROGETTO
    WHERE EMail_Creatore = Mail;
END
@ DELIMITER;

-- Finanziamento di un progetto aperto. Un utente puo finanziare anche il progetto di cui e' creatore
DROP PROCEDURE IF EXISTS finanziaProgetto;
DELIMITER @
CREATE PROCEDURE finanziaProgetto (IN EmailUtente VARCHAR(30), IN NomeProgetto VARCHAR(30), IN Importo double, 
                                    IN DataFinanziamento DATE, IN CodiceReward INT)
BEGIN
    DECLARE statoProgetto VARCHAR(20) DEFAULT 'inesistente'; -- Usare VARCHAR per ENUM

    -- Controllo se il progetto esiste e prendiamo lo stato
    SELECT Stato INTO statoProgetto
    FROM PROGETTO 
    WHERE Nome_Progetto = NomeProgetto;


    -- Se il progetto è aperto, inseriamo il finanziamento
    IF statoProgetto = 'aperto' THEN
    START TRANSACTION;
        INSERT INTO FINANZIAMENTO (Email_Utente, Nome_Progetto, Importo, Data, Codice_Reward)
        VALUES (EmailUtente, NomeProgetto, Importo, DataFinanziamento, CodiceReward);
    COMMIT;
    -- Se il progetto e' chiuso lanciamo un messaggio di errore
    ELSE IF statoProgetto = 'chiuso' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Il progetto non è aperto ai finanziamenti.';
    -- Se il progetto non esiste lanciamo un messaggio di errore
    ELSE IF statoProgetto = 'inesistente' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Il progetto non esiste.';
    END IF;
END @@

DELIMITER ;

-- Inserimento di un commento relativo ad un progetto
DROP PROCEDURE IF EXISTS inserisciCommentoProgetto;
DELIMITER @
CREATE PROCEDURE inserisciCommentoProgetto (IN EmailUtente VARCHAR(30), IN NomeProgetto VARCHAR(30), IN Testo VARCHAR(1000), IN DataCommento DATE)
BEGIN
    SET progettoEsistente INT DEFAULT 0;

    -- Controllo se il progetto esiste
    SELECT COUNT(*) INTO progettoEsistente
    FROM PROGETTO
    WHERE Nome_Progetto = NomeProgetto;

    -- Se il progetto esiste, inseriamo il commento
    IF (progettoEsistente = 1) THEN
    START TRANSACTION;
        INSERT INTO COMMENTO_PROGETTO (Email_Utente, Nome_Progetto, Testo, Data)
        VALUES (EmailUtente, NomeProgetto, Testo, DataCommento);
    COMMIT;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Il progetto non esiste.';
    END IF;

END
@ DELIMITER;


DROP PROCEDURE IF EXISTS assegnaReward;
DELIMITER @

CREATE PROCEDURE assegnaReward (IN EmailUtente VARCHAR(30), IN NomeProgetto VARCHAR(30), IN CodiceReward INT)
BEGIN
    DECLARE esisteFinanziamento INT DEFAULT 0;
    DECLARE rewardValida INT DEFAULT 0;

    -- Controlla se esiste un finanziamento da parte dell'utente per il progetto
    SELECT COUNT(*) INTO esisteFinanziamento
    FROM FINANZIAMENTO
    WHERE Email_Utente = EmailUtente 
    AND Nome_Progetto = NomeProgetto;

    -- Se non esiste alcun finanziamento, genera un errore
    IF esisteFinanziamento = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Nessun finanziamento trovato per questo utente e progetto.';
    END IF;

    -- Controlla se la reward scelta appartiene effettivamente al progetto finanziato
    SELECT COUNT(*) INTO rewardValida
    FROM REWARD
    WHERE Codice = CodiceReward
    AND Nome_Progetto = NomeProgetto;

    -- Se la reward non è valida, genera un errore
    IF rewardValida = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: La reward selezionata non è valida per questo progetto.';
    END IF;

    -- Aggiorna il finanziamento per assegnare la reward scelta
    UPDATE FINANZIAMENTO
    SET Codice_Reward = CodiceReward
    WHERE Email_Utente = EmailUtente 
    AND Nome_Progetto = NomeProgetto;

END 
@ DELIMITER ;

-- Inserimento di una candidatura per un profilo richiesto per la realizzazione di un software
DROP PROCEDURE IF EXISTS inserisciCandidatura;
DELIMITER @
CREATE PROCEDURE inserisciCandidatura (IN EmailUtente VARCHAR(30), IN NomeProgetto VARCHAR(30))
BEGIN
    SET progettoEsistente INT DEFAULT 0;

    -- Controllo se il progetto esiste
    SELECT COUNT(*) INTO progettoEsistente
    FROM PROGETTO
    WHERE Nome_Progetto = NomeProgetto;

    -- Se il progetto esiste, inseriamo la candidatura
    IF (progettoEsistente = 1) THEN
    START TRANSACTION;
        INSERT INTO CANDIDATURA (Email_Utente, Nome_Progetto)
        VALUES (EmailUtente, NomeProgetto);
    COMMIT;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Il progetto non esiste.';
    END IF;
END
@ DELIMITER;