jQuery(document).ready(function($){
  var currentPosition = 0;
  var slideWidth = 900;
  var slides = $('.deslizaForm');
  var numberOfSlides = slides.length;

  // Remove scrollbar in JS
  $('#deslizanteForm').css('overflow', 'hidden');

  // Wrap all .slides with #slideInner div
  slides
  .wrapAll('<div id="slideInnerForm"></div>')
  // Float left to display horizontally, readjust .slides width
  .css({
    'float' : 'left',
    'width' : slideWidth
  });

  // Set #slideInner width equal to total width of all slides
  $('#slideInnerForm').css('width', slideWidth * numberOfSlides);

  // Insert left and right arrow controls in the DOM
  $('#dosificadorForm')
    .prepend('<div class="navigation navigation-left alignleft"><a id="leftControl" class="controlForm" href="javascript:previous();" title="Paso anterior">&laquo;</a></div>')
    .append('<div class="navigation navigation-right alignright"><a id="rightControl" class="controlForm" href="javascript:next();" title="Paso siguiente">&raquo;</a></div>')

  // Hide left arrow control on first load
  manageControls(currentPosition);

  // Create event listeners for .controls clicks
  $('.controlForm')
    .bind('click', function(){
    // Determine new position
      currentPosition = ($(this).attr('id')=='rightControl')
    ? currentPosition+1 : currentPosition-1;

      // Hide / show controls
      manageControls(currentPosition);
      // Move slideInner using margin-left
      $('#slideInnerForm').animate({
        'marginLeft' : slideWidth*(-currentPosition)
      }, 750 );
    });

  // manageControls: Hides and shows controls depending on currentPosition
  function manageControls(position){
    // Hide left arrow if position is first slide
    if(position==0){ $('#leftControl').hide() }
    else{ $('#leftControl').show() }
    // Hide right arrow if position is last slide
    if(position==numberOfSlides-1){ $('#rightControl').hide() }
    else{ $('#rightControl').show() }
    }
  });
