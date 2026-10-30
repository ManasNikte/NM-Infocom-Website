-- One partner logo was stored with a root-relative path; make it relative like the others.
UPDATE partners SET partner_img = './assets/img/partners/partners/netmagic.png'
WHERE partner_img = '/assets/img/partners/partners/netmagic.png';
