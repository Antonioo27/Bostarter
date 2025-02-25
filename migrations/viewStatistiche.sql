USE BOSTARTER;

-- Visualizzare	la classifica degli utenti creatori, in base al loro valore di affidabilità. Mostrare solo il nickname dei primi 3 utenti.
CREATE OR REPLACE VIEW ClassificaUtentiCreatori AS
SELECT Nickname
FROM CREATORE
ORDER BY Affidabilita DESC
LIMIT 3;


-- Visualizzare i progetti APERTI che sono più vicini al proprio completamento (= minore	
-- differenza tra budget richiesto e somma totale dei finanziamenti	ricevuti). Mostrare	solo i	
-- primi 3 progetti

CREATE OR REPLACE VIEW ProgettiViciniCompletamento AS
WITH FinanziamentoTotaleProgetto AS (
    SELECT Nome_Progetto AS NomeProgetto, SUM(Importo) AS Totale
    FROM FINANZIAMENTO
    GROUP BY Nome_Progetto
)
SELECT P.*
FROM PROGETTO AS P
JOIN FinanziamentoTotaleProgetto AS F ON P.Nome = F.NomeProgetto
WHERE P.Stato = 'Aperto' 
ORDER BY (P.Budget - F.Totale) ASC
LIMIT 3;



-- Visualizzare	la classifica degli utenti,	ordinati in	base al TOTALE di finanziamenti erogati.	
-- Mostrare	solo i nickname dei primi 3	utenti.
CREATE OR REPLACE VIEW ClassificaUtentiFinanziatori AS
SELECT U.Nickname
FROM UTENTE AS U
JOIN FINANZIAMENTO AS F ON U.Email = F.Email_Utente
GROUP BY U.Email
ORDER BY SUM(F.Importo) DESC
LIMIT 3;
