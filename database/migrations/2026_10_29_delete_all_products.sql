-- Remove every product currently listed (catalogue PDFs and cover images are deleted from uploads/ in the same change).
-- Categories are kept so new products can be added straight away.
DELETE FROM `products`;
