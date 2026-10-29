<?php
// "My Profile" page body shared by every section; include after the section's top.php.
$pf = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES);
$pfDate = function ($d) {
    $t = $d ? strtotime($d) : false;
    return $t ? date('j M Y', $t) : '—';
};
$pfDept = $section['sub_role'] === 'hr' ? 'HR' : ucfirst((string) ($section['sub_role'] ?? ''));
$pfRole = $section['role'] === 'Admin' ? 'Administrator' : $section['role'];
$pfSince = !empty($user['date_of_joining']) ? (new DateTime($user['date_of_joining']))->diff(new DateTime('today')) : null;
$pfTenure = $pfSince ? ($pfSince->y ? $pfSince->y . ' yr ' . $pfSince->m . ' mo' : ($pfSince->m ? $pfSince->m . ' months' : $pfSince->d . ' days')) : '—';
?>
<div class="main-content">
  <div class="section__content section__content--p30">
    <div class="container-fluid">

      <section class="pf-cover">
        <div class="pf-avatar" aria-hidden="true"><?= $pf($initials) ?></div>
        <div class="pf-id">
          <h2><?= $pf($user['name'] ?? '') ?></h2>
          <div class="pf-tags">
            <span class="pf-tag"><i class="fas fa-user-shield"></i><?= $pf($pfRole) ?></span>
            <?php if ($pfDept !== ''): ?><span class="pf-tag"><i class="fas fa-sitemap"></i><?= $pf($pfDept) ?></span><?php endif; ?>
            <span class="pf-tag pf-tag-ok"><i class="fas fa-circle"></i><?= $pf(ucfirst($user['status'] ?: 'active')) ?></span>
          </div>
        </div>
      </section>

      <div class="pf-facts">
        <div class="pf-fact"><i class="fas fa-envelope"></i><span>Email</span><b id="pfEmail"><?= $pf($user['email'] ?? '') ?></b></div>
        <div class="pf-fact"><i class="fas fa-phone"></i><span>Phone</span><b id="pfPhone"><?= $pf($user['contact'] ?: '—') ?></b></div>
        <div class="pf-fact"><i class="fas fa-birthday-cake"></i><span>Date of birth</span><b><?= $pf($pfDate($user['dob'] ?? '')) ?></b></div>
        <div class="pf-fact"><i class="fas fa-calendar-check"></i><span>Joined</span><b><?= $pf($pfDate($user['date_of_joining'] ?? '')) ?> <small><?= $pf($pfTenure) ?></small></b></div>
      </div>

      <div class="pf-grid">
        <form class="pf-card" id="profileForm" novalidate>
          <header><span class="pf-card-icon"><i class="fas fa-address-card"></i></span><div><h3>Contact details</h3><p>How the team and the CRM reach you.</p></div></header>
          <label class="pf-field"><span>Phone number</span>
            <input type="tel" id="contact" class="form-control" value="<?= $pf($user['contact'] ?? '') ?>" placeholder="10–15 digits, e.g. 9876543210" autocomplete="tel" required />
          </label>
          <label class="pf-field"><span>Email</span>
            <input type="email" id="email" class="form-control" value="<?= $pf($user['email'] ?? '') ?>" autocomplete="email" required />
            <small>Also your sign-in email.</small>
          </label>
          <button type="submit" class="btn btn-primary pf-save"><i class="fas fa-check mr-1"></i> Save changes</button>
        </form>

        <form class="pf-card" id="passwordForm" novalidate>
          <header><span class="pf-card-icon pf-violet"><i class="fas fa-key"></i></span><div><h3>Change password</h3><p>Use at least 8 characters; mix letters, numbers and symbols.</p></div></header>
          <label class="pf-field"><span>Current password</span>
            <span class="pf-pass"><input type="password" id="currentpassword" class="form-control" autocomplete="current-password" required /><button type="button" class="pf-eye" aria-label="Show password"><i class="far fa-eye"></i></button></span>
          </label>
          <label class="pf-field"><span>New password</span>
            <span class="pf-pass"><input type="password" id="newpassword" class="form-control" autocomplete="new-password" minlength="8" required /><button type="button" class="pf-eye" aria-label="Show password"><i class="far fa-eye"></i></button></span>
            <span class="pf-meter" aria-hidden="true"><i></i></span><small id="pfStrength">&nbsp;</small>
          </label>
          <label class="pf-field"><span>Confirm new password</span>
            <span class="pf-pass"><input type="password" id="confirmpassword" class="form-control" autocomplete="new-password" required /><button type="button" class="pf-eye" aria-label="Show password"><i class="far fa-eye"></i></button></span>
          </label>
          <button type="submit" class="btn btn-primary pf-save"><i class="fas fa-lock mr-1"></i> Update password</button>
        </form>
      </div>

    </div>
  </div>
</div>

<style>
  .pf-cover {
    position: relative; overflow: hidden; display: flex; align-items: center; gap: 22px; padding: 28px; border-radius: 22px; margin-bottom: 18px;
    background: var(--crm-hero); color: #fff; box-shadow: 0 20px 40px -24px rgba(37, 99, 235, .6);
  }
  .pf-cover::after { content: ""; position: absolute; right: -80px; top: -120px; width: 340px; height: 340px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 255, 255, .2), transparent 65%); }
  .pf-avatar {
    width: 88px; height: 88px; flex: none; border-radius: 24px; display: grid; place-items: center; position: relative; z-index: 1;
    font: 800 2rem/1 var(--crm-heading-font); color: #fff; background: rgba(255, 255, 255, .16); border: 2px solid rgba(255, 255, 255, .35); backdrop-filter: blur(6px);
  }
  .pf-id { position: relative; z-index: 1; min-width: 0; }
  .pf-id h2 { color: #fff !important; font: 800 1.7rem/1.2 var(--crm-heading-font); margin: 0 0 10px; letter-spacing: -0.02em; overflow-wrap: anywhere; }
  .pf-tags { display: flex; flex-wrap: wrap; gap: 8px; }
  .pf-tag { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; font-size: .8rem; font-weight: 600; background: rgba(255, 255, 255, .15); border: 1px solid rgba(255, 255, 255, .25); }
  .pf-tag i { font-size: .75rem; opacity: .9; }
  .pf-tag-ok i { color: #6ee7b7; font-size: .5rem; }

  .pf-facts { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-bottom: 18px; }
  .pf-fact {
    display: grid; grid-template-columns: 40px minmax(0, 1fr); grid-template-rows: auto auto; column-gap: 12px; align-items: center;
    padding: 16px; border-radius: 16px; background: var(--crm-surface); border: 1px solid var(--crm-border); box-shadow: var(--crm-shadow);
  }
  .pf-fact i { grid-row: 1 / 3; width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center; background: var(--crm-primary-soft); color: var(--crm-primary); }
  .pf-fact span { font-size: .76rem; color: var(--crm-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .06em; }
  .pf-fact b { color: var(--crm-heading); font-weight: 700; font-size: .95rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
  .pf-fact b small { color: var(--crm-muted); font-weight: 500; margin-left: 4px; }

  .pf-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; align-items: start; }
  .pf-card { background: var(--crm-surface); border: 1px solid var(--crm-border); border-radius: 18px; padding: 22px; box-shadow: var(--crm-shadow); margin: 0; }
  .pf-card header { display: flex; gap: 14px; align-items: flex-start; margin-bottom: 18px; }
  .pf-card h3 { font: 800 1.05rem/1.3 var(--crm-heading-font); color: var(--crm-heading); margin: 0 0 2px; }
  .pf-card header p { margin: 0; color: var(--crm-muted); font-size: .85rem; }
  .pf-card-icon { width: 42px; height: 42px; flex: none; border-radius: 12px; display: grid; place-items: center; background: var(--crm-primary-soft); color: var(--crm-primary); }
  .pf-card-icon.pf-violet { background: rgba(139, 92, 246, .14); color: #8b5cf6; }
  .pf-field { display: block; margin: 0 0 14px; }
  .pf-field > span:first-child { display: block; font-size: .82rem; font-weight: 600; color: var(--crm-heading); margin-bottom: 6px; }
  .pf-field small { display: block; color: var(--crm-muted); font-size: .78rem; margin-top: 6px; font-weight: 500; }
  .pf-pass { position: relative; display: block; }
  .pf-pass .form-control { padding-right: 44px !important; }
  .pf-eye { position: absolute; right: 4px; top: 50%; transform: translateY(-50%); width: 36px; height: 34px; border: 0; background: none; color: var(--crm-muted); border-radius: 8px; }
  .pf-eye:hover { color: var(--crm-primary); background: var(--crm-primary-soft); }
  .pf-meter { display: block; height: 6px; border-radius: 99px; background: var(--crm-surface-2); margin-top: 8px; overflow: hidden; }
  .pf-meter i { display: block; height: 100%; width: 0; border-radius: inherit; transition: width .25s, background .25s; }
  .pf-save { width: 100%; padding: 11px 16px !important; margin-top: 4px; }
  .pf-save:disabled { opacity: .7; }

  @media (max-width: 1199px) { .pf-facts { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
  @media (max-width: 860px) { .pf-grid { grid-template-columns: minmax(0, 1fr); } }
  @media (max-width: 575px) {
    .pf-cover { flex-direction: column; align-items: flex-start; padding: 20px; gap: 14px; }
    .pf-avatar { width: 64px; height: 64px; border-radius: 18px; font-size: 1.5rem; }
    .pf-id h2 { font-size: 1.35rem; }
    .pf-facts { grid-template-columns: minmax(0, 1fr); gap: 10px; }
    .pf-card { padding: 18px 16px; }
  }
</style>

<?php require __DIR__ . '/bottom.php'; ?>
<script>
$(function () {
  const toast = (icon, title, text) => Swal.fire({ icon, title, text, timer: icon === 'success' ? 2200 : undefined, showConfirmButton: icon !== 'success' });
  const busy = (form, on) => $(form).find('.pf-save').prop('disabled', on);

  $('.pf-eye').on('click', function () {
    const input = $(this).siblings('input');
    const show = input.attr('type') === 'password';
    input.attr('type', show ? 'text' : 'password');
    $(this).attr('aria-label', show ? 'Hide password' : 'Show password').find('i').toggleClass('fa-eye fa-eye-slash');
  });

  // Rough strength: length plus character variety.
  $('#newpassword').on('input', function () {
    const v = this.value;
    let score = 0;
    if (v.length >= 8) score++;
    if (v.length >= 12) score++;
    if (/[a-z]/.test(v) && /[A-Z]/.test(v)) score++;
    if (/\d/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    const levels = [['', '0%', ''], ['Too short', '15%', '#f43f5e'], ['Weak', '35%', '#f97316'], ['Fair', '55%', '#f59e0b'], ['Good', '78%', '#10b981'], ['Strong', '100%', '#059669']];
    const [label, width, color] = v ? (v.length < 8 ? levels[1] : levels[Math.min(5, score + 1)]) : levels[0];
    $('.pf-meter i').css({ width, background: color });
    $('#pfStrength').text(label || ' ').css('color', color || '');
  });

  $('#profileForm').on('submit', function (e) {
    e.preventDefault();
    const contact = $('#contact').val().trim().replace(/[\s-]/g, '');
    const email = $('#email').val().trim();
    if (!/^\+?\d{10,15}$/.test(contact)) return toast('error', 'Check the phone number', 'Use 10 to 15 digits, optionally starting with +.');
    if (!this.email.checkValidity()) return toast('error', 'Check the email', 'Please enter a valid email address.');
    busy(this, true);
    $.post('<?= $crm ?>shared/update_profile.php', { contact, email }, null, 'json')
      .done((res) => {
        if (!res.success) return toast('error', 'Not saved', res.message || 'Failed to update profile');
        $('#pfEmail').text(email); $('#pfPhone').text(contact); $('#contact').val(contact);
        toast('success', 'Saved', 'Your contact details were updated.');
      })
      .fail(() => toast('error', 'Not saved', 'Failed to update profile'))
      .always(() => busy(this, false));
  });

  $('#passwordForm').on('submit', function (e) {
    e.preventDefault();
    const currentpassword = $('#currentpassword').val();
    const newpassword = $('#newpassword').val();
    const confirmpassword = $('#confirmpassword').val();
    if (!currentpassword || !newpassword || !confirmpassword) return toast('error', 'Missing fields', 'Fill in all three password fields.');
    if (newpassword.length < 8) return toast('error', 'Password too short', 'Use at least 8 characters.');
    if (newpassword !== confirmpassword) return toast('error', 'Passwords don’t match', 'The new password and confirmation must be the same.');
    busy(this, true);
    $.post('<?= $crm ?>shared/update_password.php', { currentpassword, newpassword, confirmpassword }, null, 'json')
      .done((res) => {
        if (!res.success) return toast('error', 'Password not changed', res.message || 'Failed to update password');
        this.reset(); $('#newpassword').trigger('input');
        toast('success', 'Password updated', 'Use the new password next time you sign in.');
      })
      .fail(() => toast('error', 'Password not changed', 'Failed to update password'))
      .always(() => busy(this, false));
  });
});
</script>
