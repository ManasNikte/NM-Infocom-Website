<?php
// Title and description per page; a page may also set $pageTitle / $pageDescription before top.php.
$pageMeta = [
    'Service.php' => ['IT Services', 'Explore NM INFOCOM services: IT security, infrastructure, cloud, enterprise mobility, engineering and web development.'],
    'ITsec.php' => ['IT Security Services', 'Endpoint, network, data and cloud security solutions that protect your business from modern threats.'],
    'ITsecEP.php' => ['Endpoint Security', 'Anti-virus, EDR, encryption, patch management and vulnerability assessment for every device in your business.'],
    'ITsecCS.php' => ['Cloud Security', 'Secure your cloud workloads, identities and data with NM INFOCOM cloud security solutions.'],
    'ITsecNS.php' => ['Network Security', 'Firewalls, secure access and network monitoring to keep threats out of your business network.'],
    'ITsecDS.php' => ['Data Security', 'Data loss prevention, backup and encryption solutions that keep business data safe and compliant.'],
    'ITInfra.php' => ['IT Infrastructure Services', 'Datacentre, private cloud, edge computing and server & storage networking built to scale with your business.'],
    'ITInfraDC.php' => ['Datacentre & Cloud Solutions', 'Design, build and modernise datacentres and private cloud platforms with NM INFOCOM.'],
    'ITInfraNEC.php' => ['Networking & Edge Computing', 'Enterprise networking, Wi-Fi and edge computing solutions for fast, reliable connectivity.'],
    'ITInfraMAO.php' => ['Management, Automation & Orchestration', 'Automate and orchestrate IT operations to cut costs and reduce downtime.'],
    'ITInfraDWT.php' => ['Digital Workplace & Transformation', 'Modern workplace solutions that help teams collaborate securely from anywhere.'],
    'cloud.php' => ['Cloud Services', 'Business email, web & FTP hosting, DNS, security and remote monitoring on reliable cloud platforms.'],
    'Mobility.php' => ['Apple Enterprise Mobility', 'iPhone, Mac and MDM programs with leasing, deployment, training and support for your workforce.'],
    'mobilityFS.php' => ['Mobility Fulfilment Services', 'Device procurement, configuration and delivery for enterprise mobility programs.'],
    'mobilityEP.php' => ['Enterprise Mobility Programs', 'Apple enterprise programs, leasing and financing options for businesses.'],
    'mobilityEM.php' => ['Enterprise Mobility Management', 'MDM and device management to secure and manage every company device.'],
    'mobilityPS.php' => ['Mobility Products & Services', 'Apple products, accessories and services for business.'],
    'mobilityR.php' => ['Mobility Resources', 'Guides and resources for enterprise mobility deployments.'],
    'products.php' => ['Products', 'Browse IT security, networking, communication and surveillance products from NM INFOCOM.'],
    'product_detail.php' => ['Product Details', 'Product specifications, catalogue and enquiry form.'],
    'Partners.php' => ['Our Partners', 'NM INFOCOM works with leading OEMs to deliver trusted hardware and software solutions.'],
    'Blogs.php' => ['Blog', 'IT security advisories, product updates and practical technology tips from NM INFOCOM.'],
    'blog-details.php' => ['Blog', 'Insights from the NM INFOCOM team.'],
    'Events.php' => ['Events', 'Upcoming and past NM INFOCOM events, webinars and workshops.'],
    'Career.php' => ['Careers', 'Join NM INFOCOM. Explore open roles in IT security, infrastructure, sales and more.'],
    'reviewform.php' => ['Leave a Review', 'Share your experience working with NM INFOCOM.'],
    'webdev.php' => ['Web Development Company', 'Custom websites, e-commerce stores and web apps built from scratch by NM INFOCOM developers, end to end, with a review meeting at every milestone.'],
 'policy.php' => ['Terms & Privacy', 'NM INFOCOM terms of service and privacy policy.'],
];
$meta = $pageMeta[basename($_SERVER['SCRIPT_NAME'])] ?? null;
$pageTitle = $pageTitle ?? ($meta ? $meta[0] . ' | NM INFOCOM' : 'NM INFOCOM | IT Security, Cloud & Infrastructure Solutions');
$pageDescription = $pageDescription ?? ($meta[1] ?? 'NM INFOCOM designs, deploys and supports IT security, cloud, infrastructure and Apple enterprise mobility for growing businesses across India. Talk to an expert today.');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta name="theme-color" content="#0b1430">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="NM INFOCOM">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta property="og:image" content="assets/img/hero/1.jpg">

  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/favicon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/nm.css" rel="stylesheet">

  <script>
    // HTML-escape a value before putting it into markup (template literals, innerHTML).
    window.esc = function (v) {
      return v == null ? '' : String(v).replace(/[&<>"'`]/g, function (c) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '`': '&#96;' }[c];
      });
    };
  </script>
  <script type="application/ld+json">
  {"@context": "https://schema.org", "@type": "Organization", "name": "NM INFOCOM", "url": "https://www.nminfocom.in",
   "logo": "assets/img/favicon.png", "areaServed": "IN", "email": "mcnikte@nminfocom.com",
   "address": {"@type": "PostalAddress", "addressLocality": "Thane West", "addressRegion": "Maharashtra", "postalCode": "400602", "addressCountry": "IN"}}
  </script>
</head>
