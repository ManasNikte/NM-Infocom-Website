-- The old contact handler HTML-encoded input before saving it. Text is now stored as typed and
-- escaped when displayed, so decode the entities htmlspecialchars() produced in existing rows.
-- (&amp; last, so "&amp;lt;" becomes "&lt;" rather than "<".)
UPDATE contact_submits SET
  name    = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name,    '&#039;', ''''), '&quot;', '"'), '&lt;', '<'), '&gt;', '>'), '&amp;', '&'),
  email   = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(email,   '&#039;', ''''), '&quot;', '"'), '&lt;', '<'), '&gt;', '>'), '&amp;', '&'),
  contact = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(contact, '&#039;', ''''), '&quot;', '"'), '&lt;', '<'), '&gt;', '>'), '&amp;', '&'),
  subject = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(subject, '&#039;', ''''), '&quot;', '"'), '&lt;', '<'), '&gt;', '>'), '&amp;', '&'),
  message = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(message, '&#039;', ''''), '&quot;', '"'), '&lt;', '<'), '&gt;', '>'), '&amp;', '&');
