-- Product cover images were saved as "/NM-Infocom/uploads/products/...", which only works when the site
-- lives in a folder of that exact name. Store them relative to the site root instead.
UPDATE products
SET cover_image = SUBSTRING(cover_image, LOCATE('uploads/', cover_image))
WHERE cover_image LIKE '%/uploads/%';
