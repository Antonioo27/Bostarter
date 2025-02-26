USE BOSTARTER;

-- aggiornare l’affidabilità di	un utente creatore.	L’affidabilità viene
-- calcolata come X è la percentuale di	progetti creati	dall’utente	che	hanno ottenuto almeno	
-- un finanziamento. L’affidabilità	viene aggiornata: (i) ogni qualvolta un utente crea	un	
-- progetto	(denominatore);	(ii) ogni qualvolta	un progetto	dell’utente riceve un	
-- finanziamento (contribuisce	al	numeratore).

DELIMITER @
CREATE TRIGGER AggiornaAffidabilita_InserimentoProgetto
AFTER INSERT ON PROGETTO
FOR EACH ROW
BEGIN
    UPDATE CREATORE
    SET Numero_Progetti = Numero_Progetti + 1
    WHERE Email_Creatore = NEW.Email_Creatore;

    DECLARE progettiFinanziati INT DEFAULT 0;

    SELECT COUNT(DISTINCT(Nome_Progetto)) INTO progettiFinanziati
    FROM FINANZIAMENTO 
    WHERE Email_Utente = NEW.Email_Creatore;

    UPDATE CREATORE
    SET Affidabilita = (progettiFinanziati / Numero_Progetti) * 100
    WHERE Email_Creatore = NEW.Email_Creatore;

END
@ DELIMITER ;

DELIMITER @
CREATE TRIGGER AggiornaAffidabilita_InserimentoFinanziamento
AFTER INSERT ON FINANZIAMENTO
FOR EACH ROW
BEGIN
    DECLARE progettiFinanziati INT DEFAULT 0;

    SELECT COUNT(DISTINCT(Nome_Progetto)) INTO progettiFinanziati
    FROM FINANZIAMENTO 
    WHERE Email_Utente = NEW.Email_Creatore;

    UPDATE CREATORE
    SET Affidabilita = (progettiFinanziati / Numero_Progetti) * 100
    WHERE Email_Creatore = NEW.Email_Creatore;

END
@ DELIMITER ;







DELIMITER |
CREATE TRIGGER AggiornaStatoProgettoFinanziato
AFTER INSERT ON FINANZIAMENTO
FOR EACH ROW
BEGIN
    IF(SELECT SUM(Importo) FROM FINANZIAMENTO WHERE Nome_Progetto = NEW.Nome_Progetto) >= (SELECT Budget FROM PROGETTO WHERE Nome = NEW.Nome_Progetto) THEN
        UPDATE PROGETTO
        SET Stato = 'Chiuso'
        WHERE Nome = NEW.Nome_Progetto;
    END IF;
END
| DELIMITER


DELIMITER |
CREATE TRIGGER AggiornaNumeroProgetti
AFTER INSERT ON PROGETTO
FOR EACH ROW
BEGIN
    UPDATE CREATORE
    SET Numero_Progetti = Numero_Progetti + 1
    WHERE Email_Creatore = NEW.Email_Creatore;
END
| DELIMITER


--Utilizzare un evento per cambiare lo stato di un progetto--
SET GLOBAL event_scheduler = ON;

DELIMITER |
CREATE EVENT AggiornaStatoProgettiDataLimite
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMP(CURRENT_DATE, '00:00:00')
DO
BEGIN
    UPDATE PROGETTO
    SET STATO = 'Chiuso'
    WHERE STATO = 'Aperto' AND Data_Limite < CURRENT_DATE;
END
| DELIMITER;