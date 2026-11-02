<?php
/*
 * CLIENT PREVIEW SWITCH (front-end only).
 *
 * true  -> the public site shows only the All Products page and the Product Detail
 *          pages (plus the thank-you page that follows a quote / inquiry form).
 *          Every other page shows a "not available yet" notice and no link points to it.
 * false -> the full website, exactly as before.
 *
 * This only changes what the Blade views render. Routes, controllers, the database
 * and the admin panel are not involved.
 */
return true;
