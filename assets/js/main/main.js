// /* ====== ON DOCUMENT READY ====== */

$(document).ready(function () {
	init();
});


function init() {
  platformDetect();
  browserSize();
  softInit();
  djax.init();
  scrollToTop();
}

function softInit() {
  if ($('.single-jetpack-portfolio').length) {
    Project.init();
    Placeholder.update();
    Project.prepare();
  } else {
    Placeholder.update();
  }

  Portfolio.init();
  Blog.init();

  frontpageSlider.init();

	AddThisIcons.init();
}

// /* ====== ON WINDOW LOAD ====== */
$window.load(function () {
	overlayInit();
	royalSliderInit();
	socialLinks.init();
  Loader.init();
	$(".pixcode--tabs").organicTabs();

	if ($('body').hasClass('blog')
		|| $('body').hasClass('project_layout-filmstrip')
		|| $('body').hasClass('project_layout-thumbnails')) {

		// html body are for ie
		$('html, body, *').mousewheel(function (event, delta) {
			// this.scrollLeft -= (delta * 30);
			this.scrollLeft -= (delta * event.deltaFactor); // delta for macos
			event.preventDefault();
		});
	}
});

// /* ====== ON RESIZE ====== */

function onResize() {
	browserSize();
}

function requestTick() {
	if (!ticking) {
		requestAnimationFrame(update);
	}
	ticking = true;
}

function update() {
	Project.getCurrent();
	Portfolio.maybeloadNextProjects();
	Blog.maybeLoadNextPosts();
	ticking = false;
}

$window.on('debouncedresize', onResize);

$window.on('scroll', function () {
	latestKnownScrollY = window.scrollY;
	latestKnownScrollX = window.scrollX;
	requestTick();
});

$document.mousemove(function (e) {
	latestKnownMouseX = e.pageX - latestKnownScrollX;
	latestKnownMouseY = e.pageY - latestKnownScrollY;
});