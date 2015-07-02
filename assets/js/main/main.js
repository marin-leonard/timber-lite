// /* ====== ON DOCUMENT READY ====== */

$(document).ready(function() {
  init();
});


function init() {
  platformDetect();
  browserSize();

  Project.init();
  Placeholder.update();
  Project.prepare();

	Portfolio.init();

	Blog.init();
	Blog.prepare();

	AddThisIcons.init();
}

// /* ====== ON WINDOW LOAD ====== */

$window.load(function() {
  // Project.getCurrent();
  //browserSize();
  //Sidebar.init();
  //navigation.init();
  //scrollToTop();
  //moveFeaturedImage();
  //magnificPopupInit();
  //logoAnimation.init();
  //logoAnimation.update();

  overlayInit();
  royalSliderInit();
  socialLinks.init();
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

$window.on('scroll', function() {
  latestKnownScrollY = window.scrollY;
  latestKnownScrollX = window.scrollX;
  requestTick();
});

$document.mousemove(function(e) {
    latestKnownMouseX = e.pageX - latestKnownScrollX;
    latestKnownMouseY = e.pageY - latestKnownScrollY;
});