$(document).ready(function(){
  var currentPosition = 0;
  var slideWidth = 900;
  var slides = $('.deslizaMess');
  var numberOfSlides = slides.length;

  // Remove scrollbar in JS
  $('#deslizanteMess').css('overflow', 'hidden');

  // Wrap all .slides with #slideInner div
  slides
  .wrapAll('<div id="slideInnerMess"></div>')
  // Float left to display horizontally, readjust .slides width
  .css({
    'float' : 'left',
    'width' : slideWidth
  });

  // Set #slideInner width equal to total width of all slides
  $('#slideInnerMess').css('width', slideWidth * numberOfSlides);

  // Insert left and right arrow controls in the DOM
  $('#dosificadorMess')
   // .prepend('<div class="controlMess" id="leftControlMess" href="javascript:previous();" title="Paso anterior">&laquo;</div>')
   // .append('<div class="controlMess" id="rightControlMess" href="javascript:next();" title="Paso siguiente">&raquo;</div>')
    //.append('<span class="control" id="rightControl">Move right</span>');

  // Hide left arrow control on first load
  manageControls(currentPosition);

  // Create event listeners for .controls clicks
  $('.controlMess')
    .bind('click', function(){
    // Determine new position
      currentPosition = ($(this).attr('id')=='rightControlMess')
    ? currentPosition+1 : currentPosition-1;

      // Hide / show controls
      manageControls(currentPosition);
      // Move slideInner using margin-left
      $('#slideInnerMess').animate({
        'marginLeft' : slideWidth*(-currentPosition)
      }, 750 );
    });

  // manageControls: Hides and shows controls depending on currentPosition
   function manageControls(position){
    // Hide left arrow if position is first slide
    if(position==0){ $('#leftControlMess').hide(); $('#navigationlefta').css('z-index', 1); }
    else{ $('#leftControlMess').show(); $('#navigationlefta').css('z-index', 0); }
    // Hide right arrow if position is last slide
    if(position==numberOfSlides-1){ $('#rightControlMess').hide(); $('#navigationa').css('z-index', 1); }
  // if(position==1){ $('#rightControlMess').hide() }
    else{ $('#rightControlMess').show(); $('#navigationa').css('z-index', 0); }
   //else { $('#rightControlMess').hide() }

    } 
  });
