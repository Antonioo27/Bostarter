USE BOSTARTER;

-- Inserimento di una nuova stringa nella lista delle competenze
DROP PROCEDURE IF EXISTS inserisciCompetenza;
DELIMITER @@
CREATE PROCEDURE inserisciCompetenza (IN NomeCompetenza VARCHAR(20), IN Email VARCHAR(50))
BEGIN
    DECLARE esisteAmministratore INT DEFAULT 0;

    SELECT COUNT(*) INTO esisteAmministratore
    FROM AMMINISTRATORE
    WHERE Email_Amministratore = Email;


    IF esisteAmministratore = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: L''utente non è un amministratore.';   
    ELSE 
    START TRANSACTION;
        INSERT INTO COMPETENZA (Nome)
        VALUES (NomeCompetenza);
    COMMIT;
    END IF;
END
@@ DELIMITER ;


DROP PROCEDURE IF EXISTS rimuoviCompetenza;
DELIMITER ||
CREATE PROCEDURE rimuoviCompetenza (IN NomeCompetenza VARCHAR(20), IN Email VARCHAR(50))
BEGIN
    DECLARE esisteAmministratore INT DEFAULT 0;

    SELECT COUNT(*) INTO esisteAmministratore
    FROM AMMINISTRATORE
    WHERE Email_Amministratore = Email;

    IF esisteAmministratore = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Errore: L''utente non è un amministratore.';
    ELSE
    START TRANSACTION;
        DELETE FROM COMPETENZA
        WHERE Nome = NomeCompetenza;
    COMMIT;
    END IF;
END
||  DELIMITER ;




-- In fase di autenticazione, oltre a username e password, l'utente deve inserire anche il codice di sicurezza
DROP PROCEDURE IF EXISTS autenticazioneAmministratore;
DELIMITER @@ 
CREATE PROCEDURE autenticazioneAmministratore (IN Email VARCHAR(50), IN CodiceSicurezza INT)
BEGIN
    SELECT U.Email, U.Password, U.Nome, U.Cognome, U.Nickname 
    FROM UTENTE AS U 
    JOIN AMMINISTRATORE AS A ON U.Email = A.Email_Amministratore 
    WHERE U.Email = Email AND A.Codice_Sicurezza = CodiceSicurezza; 
END
@@ DELIMITER ;

-- Visualizzazione delle competenze
DROP PROCEDURE IF EXISTS visualizzaCompetenze;
DELIMITER @@
CREATE PROCEDURE visualizzaCompetenze ()
BEGIN
    SELECT Nome
    FROM COMPETENZA;
END
@@ DELIMITER ;

-- In fase di autenticazione, oltre a username e password, l'utente deve inserire anche il codice di sicurezza
DROP PROCEDURE IF EXISTS Verifica_Ruolo_Amministratore;
DELIMITER @@ 
CREATE PROCEDURE Verifica_Ruolo_Amministratore (IN Email VARCHAR(50))
BEGIN
    SELECT U.Email, U.Password, U.Nome, U.Cognome, U.Nickname 
    FROM UTENTE AS U 
    JOIN AMMINISTRATORE AS A ON U.Email = A.Email_Amministratore 
    WHERE U.Email = Email AND A.Codice_Sicurezza = CodiceSicurezza; 
END
@@ DELIMITER ;

