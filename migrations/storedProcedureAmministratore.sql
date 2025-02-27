USE BOSTARTER;

-- Inserimento di una nuova stringa nella lista delle competenze
DROP PROCEDURE IF EXISTS inserisciCompetenza;
DELIMITER @
CREATE PROCEDURE inserisciCompetenza (IN NomeCompetenza VARCHAR(20), IN Email VARCHAR(30))
BEGIN
    SET esisteAmministratore INT DEFAULT 0;

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


-- In fase di autenticazione, oltre a username e password, l'utente deve inserire anche il codice di sicurezza
DROP PROCEDURE IF EXISTS autenticazioneAmministratore;
DELIMITER @ 
CREATE PROCEDURE autenticazioneAmministratore (IN Email VARCHAR(30), IN Password VARCHAR(30), IN CodiceSicurezza INT, OUT esito INT)
BEGIN
    SELECT COUNT(*) INTO esito
    FROM AMMINISTRATORE
    WHERE Email_Amministratore = Email AND Password = Password AND Codice_Sicurezza = CodiceSicurezza;
END
@ DELIMITER ;