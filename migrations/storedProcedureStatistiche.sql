USE BOSTARTER;

-- Visualizzare	la classifica degli utenti creatori, in base al loro valore di affidabilità. Mostrare solo il nickname dei primi 3 utenti.
DROP PROCEDURE IF EXISTS visualizzaClassificaUtentiCreatore;
DELIMITER @
CREATE PROCEDURE visualizzaClassificaUtentiCreatore ()
BEGIN
    SELECT Nickname
    FROM CREATORE
    ORDER BY Affidabilita DESC
    LIMIT 3;
END
@ DELIMITER;

-- Visualizzare i progetti APERTI che sono più vicini al proprio completamento (= minore	
-- differenza tra budget richiesto e somma totale dei finanziamenti	ricevuti). Mostrare	solo i	
-- primi 3 progetti

DROP PROCEDURE IF EXISTS visualizzaProgettiViciniCompletamento;
DELIMITER @
CREATE PROCEDURE visualizzaProgettiViciniCompletamento ()
BEGIN

    WITH FinanziamentoTotaleProgetto AS (
        SELECT Nome_Progetto AS NomeProgetto, SUM(Importo) AS Totale
        FROM FINANZIAMENTO
        GROUP BY Nome_Progetto;
    )

    SELECT *
    FROM PROGETTO
    JOIN FinanziamentoTotaleProgetto ON NomeProgetto = Nome_Progetto
    WHERE Stato = 'Aperto' 
    ORDER BY (Budget - Totale) DESC
    LIMIT 3;
END
@ DELIMITER ;
