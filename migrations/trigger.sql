USE BOSTARTER;

-- aggiornare l’affidabilità di	un utente creatore.	L’affidabilità viene
-- calcolata come X è la percentuale di	progetti creati	dall’utente	che	hanno ottenuto almeno	
-- un finanziamento. L’affidabilità	viene aggiornata: (i) ogni qualvolta un utente crea	un	
-- progetto	(denominatore);	(ii) ogni qualvolta	un progetto	dell’utente riceve un	
-- finanziamento (contribuisce	al	numeratore).

DELIMITER @
CREATE TRIGGER AggiornaAffidabilita
AFTER INSERT ON PROGETTO
FOR EACH ROW
BEGIN
    