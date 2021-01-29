$(document).ready(function () {

    //============= arrow scroll up
    $('.arrow-up').hide();
    if(window.matchMedia("(min-width: 1270px)").matches) {
        $(window).scroll(function() {
            if ($(this).scrollTop() > $(window).height()) {
                $('.arrow-up').fadeIn();
            } else {
                $('.arrow-up').fadeOut();
            }
        });

        $('.arrow-up').click(function() {
            $('body,html').animate({
                scrollTop: 0
            }, 600);
            return false;
        });
    };
    //============= END arrow scroll up

    //============= header
    $('.header__top__language-current').on('click',function (e) {
        $(this).next().toggleClass('open');
        $("html").one("click", function() {
            $(".header__top__language-popup").removeClass("open")
        }),
            // $(".custom-select").removeClass("opened");
            e.stopPropagation()
    });
    $('.header__bottom__burger').on('click', function () {
        $(this).toggleClass('header__bottom__burger--is-active');
        $('.header__bottom__menu').slideToggle()
    });
    $(".header__top__search__btn").on('click', function () {
        $(".header__top__search").addClass('open');
        $('footer').before($('<div class="backs"></div>'));


        $('.backs').on('click', function () {
            $(".header__top__search").removeClass('open');
            $(this).remove();
        });
    });
    //============= END header

    //============= catalog letters
    $('.catalog__content__details__letter .more').on('click', function () {
        $(this).parent().toggleClass('long');
    });

    $('.catalog__menu__details__title').on('click', function () {
        $(this).parent().toggleClass('long');
    });

    $(".calc__btn").on('click', function () {
        $(".calc").addClass('open');
        $('footer').before($('<div class="backs"></div>'));


        $('.backs').on('click', function () {
            $(".calc").removeClass('open');
            $(this).remove();
        });
        $('.calc__title span').on('click', function () {
            $(".calc").removeClass('open');
            $('.backs').remove();
        });
    });

    //============= END catalog letters



    //======== account page
    $('.account__change-pass').on('click',function () {
        $(this).nextAll('.account__change').css('display', 'flex');
        $(this).remove();
    });

    $('.account__deposit__balance__pay select').on('change', function(){
        if($(this).find('option:first-child').prop('selected')){
            console.log(123);
            $('.account__deposit__balance-confirm').show();
            $('.account__deposit__balance-download').hide();
        } else{
            $('.account__deposit__balance-confirm').hide();
            $('.account__deposit__balance-download').show();
        }
    });

    $('.account__order__header .arrow').on('click', function () {
        $(this).parent().toggleClass('open');
        $(this).parent().next().slideToggle();
    });


    // $('.account__order__body .arrow').on('click', function () {
    //    $(this).parents('.one').remove();
    // });


    $('.account__order .edit').on('click', function () {
        var form = $(this).parents('.account__order__header').next();

        $(this).parents('.account__order__header').addClass('open');
        form.addClass('redact').slideDown();
        form.find('.form-number input').addClass('form-number-input').attr("readonly", false);
    });


    $('.account__order__body .save').on('click', function (e) {
        e.preventDefault();
        $(this).parents('.account__order__body').removeClass('redact');
        $(this).parents('.account__order__body').find('.form-number input').removeClass('form-number-input').attr("readonly", true);
    });


    //======== offer page
    $('.offer__form__pay select').on('change', function(){
        if($(this).find('option:first-child').prop('selected')){
            $('.offer__form__pay--score').show();
        } else{
            $('.offer__form__pay--score').hide();
        }
    });

    // ========== input phone mask
    $("input[type='tel']").mask("+7(999) 999-99-99");

    $('.login__form__field').each(function () {
        var _this = $(this);
        var _input = $(this).find('input') ;
        _input.on('focus', function () {
            _input.siblings('.login__form__field__list').addClass('open')
            _this.find('.login__form__field__list p').on('click', function () {
                //_input.val($(this).text());
                $(this).parent().removeClass('open');
            })
        });
        _input.on('focusout', function () {
            setTimeout(function () {
                _input.siblings('.login__form__field__list').removeClass('open')
            }, 300);
        })
    });

    $('.offer__form__field').each(function () {
        var _this = $(this);
        var _input = $(this).find('input') ;
        _input.on('focus', function () {
            console.log(123);
            _input.siblings('.offer__form__field__list').addClass('open')
            _this.find('.offer__form__field__list p').on('click', function () {
                _input.val($(this).text());
                $(this).parent().removeClass('open');
            })
        });
        _input.on('focusout', function () {
            setTimeout(function () {
                _input.siblings('.offer__form__field__list').removeClass('open')
            }, 300);
        })
    });

    //------------------------see pass--------------

    $('[data-action="see-password"]').on('click', function () {
        el = '#' + $(this).attr('data-toggle');

        if ($(el).attr('type') == 'password') {
            $(this).addClass('eye-close');
            $(el).attr('type', 'text');
        } else {
            $(this).removeClass('eye-close');
            $(el).attr('type', 'password');
        }
        $(el).focus();
    });
    //======== END valid form




    //======== popups

    var closePopup;

    const $popup = $('.popup');

    function myFunction(detail) {
        $popup.removeClass('show');
        myStopFunction();

        $popup.addClass('show');
        $popup.find('.popup__desc b').text(detail);

        closePopup = setTimeout(function(){
            $('.popup').removeClass('show');
        },4000);
    }

    function myStopFunction() {
        if (closePopup) {
            clearTimeout(closePopup);
        }
    }

    const cartAmountCount = $('#cart_amount_count');

    $('.table .btn-add').on('click', function () {
        const $el = $(this);
        axios.post('/cart', {id: $el.data('id')})
            .then(res => {
                if (res.data.success === false) {
                  alert(res.data.error)
                  return;
                }

                $el.addClass('hidden');
                $el.parent().find('.btn-delete').removeClass('hidden')
                myFunction($el.data('name'));
                cartAmountCount.text(parseInt(cartAmountCount.text()) + 1)
            })
    });

    $('.table .btn-delete').on('click', function () {
        const $el = $(this);
        axios.delete(`/cart?id=${$el.data('id')}`)
            .then(res => {
                $el.addClass('hidden');
                $el.parent().find('.btn-add').removeClass('hidden');
                cartAmountCount.text(parseInt(cartAmountCount.text()) - 1)
            })
    });

    $('.popup__close').on('click', function () {
        $(this).parents('.popup').removeClass('show');
        myStopFunction()
    });

    $('#popup-order form').submit(function (e) {
      e.preventDefault();

      $form = $(this);

      const data = {};
      $.each($form.serializeArray(), (i, v) => data[v.name] = v.value);

      axios.post('/request_order', data)
        .then(res => {
          if (res.data.success === true) {
            $.fancybox.close({src:"#popup-order"})
            $.fancybox.open({src:"#popup-thnx"})
            return;
          }

          alert(res.data.error || 'Error...');
        })
        .catch(err => {
          console.log(err);

          alert('Error sending the request. Try again please.')
        })
    })

    // === search ===
    function inputSearch(headerInputSearch, headerSearchResult) {
        headerInputSearch.on("input", _.debounce(function() {
          $('#invisible_search_value').val($(this).val());

          if ($(this).val().length >= 3) {
            axios.post(window.routes.simple_search, {
              q: $(this).val()
            }).then(res => {
              headerSearchResult.html(res.data.html)
              headerSearchResult.addClass("open");
            })
          } else {
            headerSearchResult.removeClass("open");
          }
        }, 300))
    }
    inputSearch($(".header__top__search input"), $(".header__top__search .header__top__search-result"));
    inputSearch($(".search__block__field input"), $(".search__block__field .search__block__field-result"));

    $('.header__top__search-submit').click(function() {
      $('#invisible_search_form').submit()
    })
});

