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
    IN Mail            VARCHAR(50),
    IN NomeCompetenza  VARCHAR(30),
    IN Livello         INT
)
BEGIN
    DECLARE gia_presente INT;

    -- esiste già?
    SELECT COUNT(*) INTO gia_presente
    FROM   SKILL_CURRICULUM
    WHERE  Email_Utente = Mail
      AND  Nome_Competenza = NomeCompetenza;

    IF gia_presente > 0 THEN
        -- -1  ⇒ duplicato
        SELECT -1 AS esito;
    ELSE
        INSERT INTO SKILL_CURRICULUM (Email_Utente, Nome_Competenza, Livello)
        VALUES (Mail, NomeCompetenza, Livello);
        -- 1 ⇒ inserimento ok
        SELECT 1 AS esito;
    END IF;
END @@
DELIMITER ;


DROP PROCEDURE IF EXISTS visualizzaProgetto;
DELIMITER @@
CREATE PROCEDURE visualizzaProgetto (IN NomeProgetto VARCHAR(30))
BEGIN
    SELECT P.*, SUM(FN.Importo) AS Totale_Finanziamenti, F.Codice_Foto
    FROM PROGETTO P
    LEFT JOIN FINANZIAMENTO FN ON P.Nome = FN.Nome_Progetto
    LEFT JOIN FOTO F ON P.Nome = F.Nome_Progetto
    WHERE Nome = NomeProgetto
    GROUP BY P.Nome, F.Codice_Foto;
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
        INSERT INTO FINANZIAMENTO (Email_Utente, Nome_Progetto, Data, Codice_Reward, Importo)
        VALUES (EmailUtente, NomeProgetto, DataFinanziamento, CodiceReward, ImportoUtente);
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
        INSERT INTO COMMENTO (Email_Utente, Nome_Progetto, Testo, Data)
        VALUES (EmailUtente, NomeProgetto, Testo, DataCommento);
        COMMIT;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: Il progetto non esiste.';
    END IF;
END @@
DELIMITER ;


-- Visualizzazione dei commenti relativi a un progetto
DROP PROCEDURE IF EXISTS visualizzaCommentiProgetto;
DELIMITER @@
CREATE PROCEDURE visualizzaCommentiProgetto (IN NomeProgetto VARCHAR(30))
BEGIN
    SELECT C.*, R.Testo AS Reply
    FROM COMMENTO C
    LEFT JOIN RISPOSTA R ON C.ID = R.ID_Commento
    WHERE C.Nome_Progetto = NomeProgetto;
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


DROP PROCEDURE IF EXISTS visualizzaRewardsProgetto;
DELIMITER @@
CREATE PROCEDURE visualizzaRewardsProgetto(IN pNomeProgetto VARCHAR(20))
BEGIN
    SELECT *
    FROM REWARD
    WHERE Nome_Progetto = pNomeProgetto;
END @@
DELIMITER ;


-- Inserimento di una candidatura
DROP PROCEDURE IF EXISTS inserisciCandidatura;
DELIMITER @@
CREATE PROCEDURE inserisciCandidatura (
    IN  EmailUtente   VARCHAR(50),
    IN  NomeProgetto  VARCHAR(30),
    IN  NomeProfilo   VARCHAR(30)
)
BEGIN
    DECLARE Nome_Competenza_Richiesta  VARCHAR(50);
    DECLARE Livello_Competenza_Richiesta INT;
    DECLARE candidatura_valida BOOLEAN DEFAULT TRUE;
    DECLARE skill_trovata INT DEFAULT 0;
    DECLARE fine_cursor   INT DEFAULT 0;

    DECLARE cursore_skillRichiesta CURSOR FOR
        SELECT Nome_Competenza, Livello
        FROM   SKILL_RICHIESTE
        WHERE  Nome_Profilo = NomeProfilo;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET fine_cursor = 1;

    START TRANSACTION;

    OPEN cursore_skillRichiesta;

    ciclo: LOOP
        FETCH cursore_skillRichiesta
        INTO  Nome_Competenza_Richiesta, Livello_Competenza_Richiesta;

        IF fine_cursor THEN
            LEAVE ciclo;
        END IF;

        SELECT COUNT(*) INTO skill_trovata
        FROM   SKILL_CURRICULUM
        WHERE  Email_Utente    = EmailUtente
          AND  Nome_Competenza = Nome_Competenza_Richiesta
          AND  Livello        >= Livello_Competenza_Richiesta;

        IF skill_trovata = 0 THEN
            SET candidatura_valida = FALSE;
            LEAVE ciclo;
        END IF;
    END LOOP;

    CLOSE cursore_skillRichiesta;

    IF candidatura_valida THEN
        INSERT INTO CANDIDATURA (Email_Utente, Nome_Profilo, Nome_Progetto, Stato)
        VALUES (EmailUtente, NomeProfilo, NomeProgetto, 'In Attesa');
        COMMIT;
        /* restituisco 1 = successo */
        SELECT 1 AS esito;
    ELSE
        ROLLBACK;
        /* restituisco -1 = non valida */
        SELECT -1 AS esito;
    END IF;
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


DROP PROCEDURE IF EXISTS ottieniProfili;
DELIMITER @@
CREATE PROCEDURE ottieniProfili (IN EmailUtente VARCHAR(50))
BEGIN
    SELECT PR.Nome, PR.Nome_ProgettoSoftware
    FROM PROFILO_RICHIESTO AS PR
    JOIN PROGETTO AS P ON PR.Nome_ProgettoSoftware = P.Nome
    WHERE PR.Nome NOT IN (
        SELECT Nome_Profilo
        FROM CANDIDATURA
        WHERE Email_Utente = EmailUtente
    ) AND P.Email_Creatore <> EmailUtente;
END @@
DELIMITER ;


-- Verifica il ruolo della mail, Creatore, Amministratore o Utente normale
DROP PROCEDURE IF EXISTS Ottieni_Ruolo_Utente;
DELIMITER @@
CREATE PROCEDURE Ottieni_Ruolo_Utente(
    IN EmailUtente VARCHAR(50)
)
BEGIN
    DECLARE Ruolo INT DEFAULT 3;

    IF EXISTS (SELECT 1 FROM AMMINISTRATORE WHERE Email_Amministratore = EmailUtente) THEN
        SET Ruolo = 1;
    ELSEIF EXISTS (SELECT 1 FROM CREATORE WHERE Email_Creatore = EmailUtente) THEN
        SET Ruolo = 2;
    END IF;

    SELECT Ruolo;
END @@
DELIMITER ;
