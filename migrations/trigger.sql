USE BOSTARTER;

-- Trigger per aggiornare l'affidabilità quando un progetto viene creato
DROP TRIGGER IF EXISTS AggiornaAffidabilita_InserimentoProgetto;
DELIMITER ||
CREATE TRIGGER AggiornaAffidabilita_InserimentoProgetto
AFTER INSERT ON PROGETTO
FOR EACH ROW
BEGIN
    -- Aggiorna il numero di progetti creati dal creatore
    UPDATE CREATORE
    SET Numero_Progetti = Numero_Progetti + 1
    WHERE Email_Creatore = NEW.Email_Creatore;

    -- Aggiorna l'affidabilità in base ai progetti finanziati
    UPDATE CREATORE
    SET Affidabilita = (
        CASE 
            WHEN Numero_Progetti = 0 THEN 0
            ELSE (
                (SELECT COUNT(DISTINCT Nome_Progetto)
                 FROM FINANZIAMENTO 
                 WHERE Email_Utente = NEW.Email_Creatore
                ) / Numero_Progetti
            ) * 100
        END
    )
    WHERE Email_Creatore = NEW.Email_Creatore;
    
END ||
DELIMITER ;

-- Trigger per aggiornare l'affidabilità quando un progetto riceve un finanziamento
DROP TRIGGER IF EXISTS AggiornaAffidabilita_InserimentoFinanziamento;
DELIMITER ||
CREATE TRIGGER AggiornaAffidabilita_InserimentoFinanziamento
AFTER INSERT ON FINANZIAMENTO
FOR EACH ROW
BEGIN
    DECLARE progettiFinanziati INT DEFAULT 0;

    -- Conta i progetti finanziati dall'utente
    SELECT COUNT(DISTINCT Nome_Progetto) INTO progettiFinanziati
    FROM FINANZIAMENTO 
    WHERE Email_Utente = NEW.Email_Utente;

    -- Evita la divisione per zero e aggiorna l'affidabilità
    UPDATE CREATORE
    SET Affidabilita = (
        CASE 
            WHEN Numero_Progetti = 0 THEN 0
            ELSE (progettiFinanziati / Numero_Progetti) * 100
        END
    )
    WHERE Email_Creatore = NEW.Email_Utente;
END ||
DELIMITER ;

-- Trigger per aggiornare lo stato del progetto quando viene raggiunto il budget
DROP TRIGGER IF EXISTS AggiornaStatoProgettoFinanziato;
DELIMITER ||
CREATE TRIGGER AggiornaStatoProgettoFinanziato
AFTER INSERT ON FINANZIAMENTO
FOR EACH ROW
BEGIN
    -- Verifica se il progetto ha raggiunto il budget
    IF (
        (SELECT SUM(Importo) FROM FINANZIAMENTO WHERE Nome_Progetto = NEW.Nome_Progetto) 
        >= 
        (SELECT Budget FROM PROGETTO WHERE Nome = NEW.Nome_Progetto)
    ) THEN
        UPDATE PROGETTO
        SET Stato = 'Chiuso'
        WHERE Nome = NEW.Nome_Progetto;
    END IF;
END ||
DELIMITER ;

-- Trigger per aggiornare il numero di progetti creati da un creatore
DROP TRIGGER IF EXISTS AggiornaNumeroProgetti;
DELIMITER ||
CREATE TRIGGER AggiornaNumeroProgetti
AFTER INSERT ON PROGETTO
FOR EACH ROW
BEGIN
    UPDATE CREATORE
    SET Numero_Progetti = Numero_Progetti + 1
    WHERE Email_Creatore = NEW.Email_Creatore;
END ||
DELIMITER ;

-- Evento per aggiornare lo stato dei progetti alla data limite
SET GLOBAL event_scheduler = ON;
DROP EVENT IF EXISTS AggiornaStatoProgettiDataLimite;
DELIMITER ||
CREATE EVENT AggiornaStatoProgettiDataLimite
ON SCHEDULE 
    EVERY 1 DAY 
    STARTS TIMESTAMP(CURRENT_DATE, '10:37:00')
DO
BEGIN
    UPDATE PROGETTO
    SET Stato = 'Chiuso'
    WHERE Stato = 'Aperto' AND Data_Limite < CURRENT_DATE;
END ||
DELIMITER ;

