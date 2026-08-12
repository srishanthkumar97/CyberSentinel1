<?php

define( 'SENTINEL_WEB_PAGE_TO_ROOT', '' );
require_once SENTINEL_WEB_PAGE_TO_ROOT . 'sentinel/includes/sentinelPage.inc.php';

sentinelPageStartup( array( ) );

$page = sentinelPageNewGrab();
$page[ 'title' ]   = 'About' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'about';

$page[ 'body' ] .= "
<div class=\"body_padded about-page\">
	<section class=\"about-intro\">
		<h2>About Cyber Sentinel</h2>
		<p>Cyber Sentinel is a PHP/MySQL web application intentionally designed with vulnerabilities to help developers learn secure coding by doing.</p>
		<p>The project is maintained by <strong>srishanthkumar97</strong> and continues to evolve with new challenges, tutorials, and interface improvements.</p>
	</section>

	<section class=\"about-grid\">
		<article class=\"about-card\">
			<h3>Project Links</h3>
			<ul class=\"about-list\">
				<li>Repo: " . sentinelExternalLinkUrlGet( 'https://github.com/srishanthkumar97/cybersentinel', 'GitHub Repository' ) . "</li>
				<li>Docker: " . sentinelExternalLinkUrlGet( 'https://hub.docker.com/r/5herl0ck/cybersentinel', 'Docker Hub Image' ) . "</li>
			</ul>
		</article>

		<article class=\"about-card\">
			<h3>Credits</h3>
			<p>This project is inspired by " . sentinelExternalLinkUrlGet( 'https://github.com/digininja/DVWA', 'DVWA' ) . ".</p>
			<ul class=\"about-list\">
				<li>Maintainer: " . sentinelExternalLinkUrlGet( 'https://github.com/srishanthkumar97', 'srishanthkumar97' ) . "</li>
			</ul>
		</article>

		<article class=\"about-card\">
			<h3>License</h3>
			<p>Cyber Sentinel is free software under the GNU General Public License version 3 or later.</p>
		</article>
	</section>

	<section class=\"about-section\">
		<h3>Development</h3>
		<p>Everyone is welcome to contribute and help make Cyber Sentinel more useful, more secure, and easier to learn from.</p>
	</section>
</div>\n";

sentinelHtmlEcho( $page );

exit;
