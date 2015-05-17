(function ($) {
    $(document).ready(function () {
        $('select').chosen({disable_search: true, width: '188px'});

        $(".carusel .lst").smoothDivScroll({
            autoScrollingMode: "onStart"
        });

        /*  function initializeMap() {
         var myLatlng = new google.maps.LatLng(59.867472, 30.327583);
         var myOptions = {
         zoom: 16,
         center: myLatlng,
         mapTypeId: google.maps.MapTypeId.ROADMAP,
         scrollwheel: false

         };
         var map = new google.maps.Map(document.getElementById("map"), myOptions);

         var marker = new google.maps.Marker({
         position: new google.maps.LatLng(59.866699, 30.319785),
         map: map,
         title: 'Московский проспект, д. 165'
         });



         return map;
         } */

        //  ymaps.ready(initializeMap);
        //
        //  function initializeMap() {
        //      myMap = new ymaps.Map('map', {
        //          center: [59.867472, 30.327583],
        //          zoom: 16
        //      });
        //
        //      var placemark = new ymaps.Placemark([59.866699, 30.319785], {
        //          name: 'Мы здесь'
        //      }, {
        //          balloonPanelMaxMapArea: 0
        //      });
        //
        //      myMap.geoObjects.add(placemark);
        ////      myMap.disableScrollZoom();
        //
        //  }

        $bxslider = $('.slider').bxSlider({
            nextText: '>',
            prevText: '<'
        });


        function selectArticle($sel) {

            $('.art-btns a').removeClass('active');
            $sel.addClass('active');

            $('.art-tab').hide().removeClass('active');

            $($sel.attr('href')).show().addClass('active');
            $('html, body').scrollTo(0, $sel.attr('href'));
        }

        function selectTabByIndex(prefix, index, $sel) {
            id = prefix + index;
            $sel.find('.tabs .lst .itm a').removeClass('active');
            $('.tabs .lst .itm a[href="' + id + '"]').addClass('active');
            $sel.find('.tabs .tab').hide();
            $(id).show().addClass('active');


            $(id).find('a').each(function () {
                //href = $(this).attr('href');

                selectArticle($(this));

                return 0;
            })
        }

        $('.tabs .lst a').each(function () {
            $(this).click(function (e) {
                e.preventDefault();

                var $lst = $(this).parent().parent();
                $lst.find('a').removeClass('active');
                $(this).addClass('active');
                $lst.nextAll().removeClass('active').hide();

                $($(this).attr('href')).show().addClass('active');
            });
        });

        $('.art-btns a').click(function (e) {
            e.preventDefault();
            selectArticle($(this));
        });

        $($('.radio-text.active').attr('href')).val($('.radio-text.active').html());

        $('.radio-text').on('click', function (e) {
            e.preventDefault();
            $('.radio-text').removeClass('active');
            $(this).addClass('active');
            var dest_id = $(this).attr('href');
            $(dest_id).val($(this).html());
        });

        $('.sct-menu a, .scroll-to').not('.no-scroll').click(function (e) {
            e.preventDefault();

            var href = $(this).attr('href');
            var tab, parts;


            if (href.indexOf(':') + 1) { //Если ссылка содержит : значит нам нужно открыть после прокрутки вкладку
                parts = href.split(':');

                href = parts[0];
                tab = parts[1];


                selectTabByIndex('#artf-tab-', tab, $(href));

            }

            //  alert (href);

            $('html, body').scrollTo(0, href);

        });

        $('.want-it').click(function (e) {
            e.preventDefault();
            $('html, body').scrollTo(0, '#sct-map');
            $('input[name="theme"]').val($(this).html());
        });

        $('.its-mine').click(function (e) {
            e.preventDefault();
            $('html, body').scrollTo(0, '#sct-hdr');
            var metro = $(this).parent().prevAll('.subway').html().trim();

            var price = $(this).parent().parent().parent().find('.price').html().trim();
            $('input[name="subway"]').val(metro);
            $('input[name="cost"]').val(price);
        });

        $('.mnu-btn').on('click', function (e) {
            e.preventDefault();
            $('#sct-menu').toggle().height($(window).height());
            $('#sct-hdr').toggleClass('menued');
        });


        $("a.sdat").click(function () {
            $("#sct-services a.active").removeClass('active');
            $("#sct-services [href^='#service-tab1']").addClass('active');
            $("#sct-services .tab").removeClass('active').hide();
            $("#service-tab1").show().addClass('active');
        });


        $("#order-frm").submit(function () {
            var $form = $(this).closest("#order-frm");
            if ($form) {
                var $button = $("#order_Send");
                var $old_text = $button.text();
                // New text
                $button.text('Отправляю..');
                // Send
                var url = $("#order-frm").attr("action");
                var Data = $("#order-frm").serialize();
                $.post(url, Data, function (result) {
                    //var response = $.parseJSON(result);
                    if (result.success == true) {
                        $form.get(0).reset();
                        $button.text($old_text);
                        alert("Спасибо за ваше сообщение. Мы свяжемся с вами в течение ближайшего часа.");
                    } else {
                        $button.text($old_text);
                        alert("Проверьте правильность заполнения полей");
                    }
                });
            }
            return false;
        });

    });
})(jQuery);