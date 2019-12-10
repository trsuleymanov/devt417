$(document).ready(function () {

    $(".reservation-step-line-selecte input").focus(function () {
        $(".reservation-step-line-selecte").removeClass("reservation-step-line-selecte-active");
        $(this).parent().addClass("reservation-step-line-selecte-active");
    });
    $(document).mouseup(function (e) {
        var div = $(".reservation-step-line-selecte-active");
        if (!div.is(e.target) &&
            div.has(e.target).length === 0) {
            div.removeClass("reservation-step-line-selecte-active");
            if ($(".js-showMap input").val() != "") {
                if ($(".reservation-step-map").css("display") == "none") {
                    $(".reservation-step-map").show();
                }
            } else {}
        }
        $(".reservation-step-line-selecte input")
    });
    $(".reservation-step-line-selecte-drop-item").click(function () {
        var this_input = $(this).parent().parent().parent().find("input");
        console.log(this_input);
        $(this_input).val($(this).text());
    });

    // Address popup inner functional
    $(".reservation-drop-offer__cover").click(function (event) {
        $(event.currentTarget).parent().children(".reservation-drop-offer__list").toggleClass("d-b");
        $(event.currentTarget).find(".reservation-drop-offer__cover-arrow").toggleClass("arrow--rotated");
    });

    $(".reservation-drop__search-geo").click(function (event) {
        $(".reservation-drop__map").toggleClass("d-b");
    });
    $(".reservation-drop__selected-showmap").click(function () {
        $(".reservation-drop__selected-map").toggleClass("d-b");
    });

    // Main popups
    $(".reservation-step-line-selecte--1").click(function () {

        $(".reservation-drop--1").toggleClass("d-b");
        addMainOverlay( $(".reservation-drop--1") );
        if (window.innerWidth > 998) {

        } else {
            $(".reservation-drop--1").css("top", -$(".reservation-step--first").offset().top);
            $(".wrapper").css("height", $(".reservation-drop--1").css("height"));
            $(".reservation-drop__content").click(function () {
                $(".wrapper").css("height", $(".reservation-drop--1").css("height"));
            });
        }
        $(".reservation-menu").removeClass("d-f");

    });

    $(".reservation-step-line-selecte--2").click(function() {
        $(".reservation-drop--2").toggleClass("d-b");
        addMainOverlay( $(".reservation-drop--2") );
        if (window.innerWidth > 998) {

        } else {
            $(".reservation-drop--2").css("top", -$(".reservation-step--first").offset().top);
            $(".wrapper").css("height", $(".reservation-drop--2").css("height"));
            $(".reservation-drop__content").click(function () {
                $(".wrapper").css("height", $(".reservation-drop--2").css("height"));
            });
        }
        $(".reservation-menu").removeClass("d-f");
    });

    $(".reservation-drop--1 .reservation-drop__topline-cancel").click(function () {
        $(".reservation-drop--1").removeClass("d-b");
        removeMainOverlay();
        $(".wrapper").css("height", "auto");
    });

    $(".reservation-drop--2 .reservation-drop__topline-cancel").click(function () {
        $(".reservation-drop--2").removeClass("d-b");
        removeMainOverlay()
        $(".wrapper").css("height", "auto");
    });

    function addOverlay($popup, triggerActiveClass) {
        $("body").append('<div class="popup-overlay"></div>');
        $(".popup-overlay").click(function(event) {
            $("." + triggerActiveClass).removeClass(triggerActiveClass);
            $popup.removeClass("d-b");
            $(event.currentTarget).remove();
        });
    }
    function addMainOverlay($popup, triggerActiveClass) {
        $("body").append('<div class="main-overlay"></div>');
        $(".main-overlay").click(function(event) {
            $("." + triggerActiveClass).removeClass(triggerActiveClass);
            $popup.removeClass("d-b");
            $(event.currentTarget).remove();
        });
    }
    function removeOverlay() {
        $(".popup-overlay").remove();
    }
    function removeMainOverlay() {
        $(".main-overlay").remove();
    }

    // Card maps
    $(".reservation-step-line-showmap").click(function(event) {
        $(event.currentTarget).closest(".reservation-step-line-content").find(".reservation-step-line-map").toggleClass("d-b");
    })
    // Burger
    $(".burger").click(function () {
        $(".reservation-menu").toggleClass("d-f");

        $("body").append('<div class="burger-overlay"></div>');
        $(".burger-overlay").click(function(event) {
            $(".reservation-menu").removeClass("d-f");
            $(event.currentTarget).remove();
        });
    });

    // Secondary popups
    $(".reservation-item__input-time").click(function (event) {
        $(".reservation-popup-time").addClass("d-b");
        if ( !( $(event.currentTarget).hasClass("reservation-item__input-time--active") ) ) {
            addOverlay($(".reservation-popup-time"), "reservation-item__input-time--active");
        }
        $(event.currentTarget).addClass("reservation-item__input-time--active");
    });

    $(".reservation-item__input-luggage").click(function (event) {
        $(".reservation-popup-luggage").addClass("d-b");
        if ( !( $(event.currentTarget).hasClass("reservation-item__input-luggage--active") ) ) {
            addOverlay($(".reservation-popup-luggage"), "reservation-item__input-luggage--active");
        }
        $(event.currentTarget).addClass("reservation-item__input-luggage--active");
    });

    $(".reservation-drop__search-input").click(function (event) {
        $(".reservation-popup-search").toggleClass("d-b");
        $(event.currentTarget).toggleClass("reservation-drop__search-input--active");
    });

    $(".reservation-drop__select-select").click(function (event) {
        $(".reservation-popup-select").toggleClass("d-b");
        $(event.currentTarget).toggleClass("reservation-drop__select-select--active");
    });

    $(".reservation-popup__item-small").click(function (event) {
        let value = $(event.currentTarget).text();
        $(event.currentTarget).closest(".reservation-popup-child").removeClass("d-b");
        $(event.currentTarget).closest(".reservation-popup__child-item").find(".reservation-item__input").removeClass("reservation-popup__input-child--active");
        $(event.currentTarget).closest(".reservation-popup__child-item").find(".reservation-item__input").val(value);
    });

    $(".reservation-popup__input-child").click(function (event) {
        if (!($(event.currentTarget).closest(".reservation-popup__child-item").children(".reservation-popup-child").hasClass("d-b"))) {
            $(".reservation-popup-child").removeClass("d-b");
            $(event.currentTarget).closest(".reservation-popup__child-item").children(".reservation-popup-child").toggleClass("d-b");
        } else {
            $(".reservation-popup-child").removeClass("d-b");
        }
        $(event.currentTarget).toggleClass("reservation-popup__input-child--active");
    });

    // Counters
    $(".reservation-popup-luggage .reservation-popup__counter-minus, .reservation-popup__counter-plus").click(function() {
        setTimeout(function() {
            let suitcaseNum = $(".reservation-popup-luggage .reservation-popup__item").first().find(".reservation-popup__counter-num").text();
            let bagNum = $(".reservation-popup-luggage .reservation-popup__item").last().find(".reservation-popup__counter-num").text();
            let message = "Чемоданы - " + suitcaseNum + ", ручная кл. - " + bagNum;
            console.log(message);
            $(".reservation-item__input-luggage").val(message);
        }, 0);
    });

    $(".reservation-popup__counter-plus").click(function (event) {
        let counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
        counter++;
        $(event.currentTarget).parent().children(".reservation-popup__counter-num").text(counter);
    });

    $(".reservation-popup__counter-minus").click(function (event) {
        let counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
        if (counter > 0) {
            counter--;
            $(event.currentTarget).parent().children(".reservation-popup__counter-num").text(counter);
        }
    });

    $(".reservation-popup__counter-child .reservation-popup__counter-plus").click(function (event) {
        let counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
        $(".reservation-popup__child-item").addClass("d-b");
        if (counter > 1) {
            let $childItem = $(".reservation-popup__child-item").first().clone(true);
            for (let i = 0; i < counter; i++) {
                $(".reservation-popup__item-big-child").append($childItem);
            }
        }
    });

    $(".reservation-popup__counter-child .reservation-popup__counter-minus").click(function (event) {
        let counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
        let $lastChildItem = $(".reservation-popup__child-item").last();
        if (counter > 0) {
            $lastChildItem.remove();
        } else if (counter == 0) {
            $(".reservation-popup__child-item").removeClass("d-b");
        }
    });

    let calcCounter = $(".reservation-calc__counter-num").text();

    $(".reservation-popup-calc .reservation-popup__counter-plus").click(function() {
        calcCounter++;
        $(".reservation-calc__counter-num").text(calcCounter);

        if (isCompletedAddress && isCompletedDest) {
            $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
        }
    });

    $(".reservation-popup-calc .reservation-popup__counter-minus").click(function() {
        if (calcCounter > 0) {
            calcCounter--;
            $(".reservation-calc__counter-num").text(calcCounter);
        }

        if (calcCounter == 0) {
            $(".reservation-calc__button").addClass("reservation-calc__button--disabled");
        }
    });


    $(".reservation-calc__counter-plus").click(function (event) {
        let counter = $(event.currentTarget).parent().children(".reservation-calc__counter-num").text();
        //counter++;

        // if (isCompletedAddress && isCompletedDest) {
        //   $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
        // }

        $(event.currentTarget).parent().children(".reservation-calc__counter-num").text(counter);
        // if (counter > 0) {
        //   $(".reservation-popup-calc").addClass("d-b");
        //   addOverlay($(".reservation-popup-calc"));
        // }
        $(".reservation-popup-calc").addClass("d-b");
        addOverlay($(".reservation-popup-calc"));
    });

    // $(".reservation-calc__counter-minus").click(function (event) {
    //   let counter = $(event.currentTarget).parent().children(".reservation-calc__counter-num").text();
    //   if (counter > 0) {
    //     counter--;
    //     $(event.currentTarget).parent().children(".reservation-calc__counter-num").text(counter);
    //     if (counter == 0) {
    //       $(".reservation-popup-calc").removeClass("d-b");
    //       removeOverlay();
    //     }
    //   }

    //   if (counter == 0) {
    //     $(".reservation-calc__button").addClass("reservation-calc__button--disabled");
    //   }
    // });

    //Inputs
    $(".reservation-popup-search .reservation-popup__item").click(function (event) {
        let value = $(event.currentTarget).find(".reservation-popup__item-text").text();
        $(event.currentTarget).closest(".reservation-drop__search").find(".reservation-drop__search-input").removeClass("reservation-drop__search-input--active");
        $(event.currentTarget).closest(".reservation-drop__search").find(".reservation-drop__search-input").val(value);
        $(event.currentTarget).closest(".reservation-popup-search").removeClass("d-b");
    });

    $(".reservation-popup-select .reservation-popup__item").click(function (event) {
        let value = $(event.currentTarget).find(".reservation-popup__item-text").text();
        $(event.currentTarget).closest(".reservation-drop__select-select-wrap").find(".reservation-drop__select-select").removeClass("reservation-drop__select-select--active");
        $(event.currentTarget).closest(".reservation-drop__select-select-wrap").find(".reservation-drop__select-select").val(value);
        $(event.currentTarget).closest(".reservation-popup-select").removeClass("d-b");
    });

    //Address steps
    let isCompletedAddress = false;
    let isCompletedDest = false;

    $(".reservation-drop-offer__item").click(addressToStep2);
    $(".reservation-popup-search .reservation-popup__item").click(addressToStep2);
    $(".reservation-drop__time-back-wrap").click(addressToStep1);
    $(".reservation-drop__time-item").click(addressComplete);
    $(".reservation-step-line-address-wrap").click(fromStep3CardToStep1);

    function addressToStep1() {
        $(".reservation-drop-offer").removeClass("d-n");
        $(".reservation-drop__search").removeClass("d-n");
        $(".reservation-drop__selected").removeClass("d-b");
        $(".reservation-drop__time").removeClass("d-b");
    }

    function addressToStep2() {
        $(".reservation-drop-offer").addClass("d-n");
        $(".reservation-drop__search").addClass("d-n");
        $(".reservation-drop__selected").addClass("d-b");
        $(".reservation-drop__time").addClass("d-b");
        $(".reservation-drop__map").removeClass("d-b");
    }

    function addressComplete() {
        isCompletedAddress = true;
        removeMainOverlay();
        if (isCompletedAddress && isCompletedDest) {
            $(".reservation-average").addClass("d-b");
        } else {
            $(".reservation-average").removeClass("d-b");
        }

        if (isCompletedAddress && isCompletedDest && ($(".reservation-calc__counter-num").text() > 0)) {
            $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
        }

        addressToStep1();
        setTimeout(function () {
            $(".wrapper").css("height", "auto");
        }, 1);
        $(".reservation-drop--1").removeClass("d-b");
        $(".reservation-step-line-content-top-left--empty1").addClass("d-n");
        $(".reservation-step-line-content-top-left--ready1").addClass("d-b");
        $(".reservation-step-line-selecte--1").addClass("d-n");
    }

    function addressReturn() {
        isCompletedAddress = false;
        $(".reservation-average").removeClass("d-b");
        $(".reservation-drop--1").addClass("d-b");
        $(".reservation-step-line-content-top-left--empty1").removeClass("d-n");
        $(".reservation-step-line-content-top-left--ready1").removeClass("d-b");
        $(".reservation-step-line-selecte--1").removeClass("d-n");
        if ($(".main-overlay").length == 0) {
            addMainOverlay($(".reservation-drop--1"));
        }
    }

    $(".reservation-popup-select .reservation-popup__item").click(destComplete);
    $(".reservation-step-line-change2").click(destReturn);

    function destComplete() {
        isCompletedDest = true;
        removeMainOverlay();
        if (isCompletedAddress && isCompletedDest) {
            $(".reservation-average").addClass("d-b");
        } else {
            $(".reservation-average").removeClass("d-b");
        }

        if (isCompletedAddress && isCompletedDest && ($(".reservation-calc__counter-num").text() > 0)) {
            $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
        }

        setTimeout(function () {
            $(".wrapper").css("height", "auto");
        }, 1);
        $(".reservation-drop--2").removeClass("d-b");
        $(".reservation-step-line-content-top-left--empty2").addClass("d-n");
        $(".reservation-step-line-content-top-left--ready2").addClass("d-b");
        $(".reservation-step-line-selecte--2").addClass("d-n");
    }

    function destReturn() {
        isCompletedDest = false;
        $(".reservation-average").removeClass("d-b");
        $(".reservation-drop--2").addClass("d-b");
        $(".reservation-step-line-content-top-left--empty2").removeClass("d-n");
        $(".reservation-step-line-content-top-left--ready2").removeClass("d-b");
        $(".reservation-step-line-selecte--2").removeClass("d-n");
        if ($(".main-overlay").length == 0) {
            addMainOverlay($(".reservation-drop--1"));
        }
    }

    //Main steps
    $(".reservation-calc__button").click(function (event) {
        if (!($(event.currentTarget).hasClass("reservation-calc__button--disabled"))) {
            cardToStep2();
        }
    });
    $(".reservation-step-line-address-wrap").click(fromStep3CardToStep1_address);
    $(".reservation-step-line-change2").click(fromStep3CardToStep1_dest);
    $(".reservation-step-info__change").click(fromStep3CardToStep1);

    //$(".reservation-back--2").addClass("d-n");
    //$(".reservation-back--3").addClass("d-n");

    //$(".reservation-back--2").click(fromStep2CardToStep1);
    //$(".reservation-back--3").click(fromStep3CardToStep2);

    // function fromStep2CardToStep1() {
    //   $("html, body").animate({ scrollTop: 0 }, "slow");
    //   // $(".reservation-back--1").removeClass("d-n");
    //   // $(".reservation-back--2").addClass("d-n");
    //   // $(".reservation-back--3").addClass("d-n");
    //   $(".reservation-undertitle--1").removeClass("d-n");
    //   $(".reservation-undertitle--2").removeClass("d-b");
    //   $(".reservation-undertitle--3").removeClass("d-b");

    //   $(".reservation-form--step1").removeClass("d-n");
    //   $(".reservation-form--step2").removeClass("d-b");

    //   $(".reservation-calc__button").unbind();
    //   $(".reservation-calc__button").click(function (event) {
    //     if (!($(event.currentTarget).hasClass("reservation-calc__button--disabled"))) {
    //       cardToStep3();
    //     }
    //   });
    //   let counter = $(".reservation-calc__counter-num").text();
    //   if (isCompletedAddress && isCompletedDest && counter > 0) {
    //     $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
    //   }

    //   $(".reservation-calc__counter-plus").unbind();
    //   $(".reservation-calc__counter-plus").click(function(event) {
    //     let counter = $(event.currentTarget).parent().children(".reservation-calc__counter-num").text();
    //     //counter++;

    //     if (isCompletedAddress && isCompletedDest) {
    //       $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
    //     }

    //     $(event.currentTarget).parent().children(".reservation-calc__counter-num").text(counter);
    //     // if (counter > 0) {
    //     //   $(".reservation-popup-calc").addClass("d-b");
    //     //   addOverlay($(".reservation-popup-calc"));
    //     // }
    //     $(".reservation-popup-calc").addClass("d-b");
    //   addOverlay($(".reservation-popup-calc"));
    //   });

    //   $(".reservation-calc__button").unbind();
    //   $(".reservation-calc__button").click(function (event) {
    //     if (!($(event.currentTarget).hasClass("reservation-calc__button--disabled"))) {
    //       cardToStep2();
    //     }
    //   });

    // }
    // function fromStep3CardToStep2() {
    //   $("html, body").animate({ scrollTop: 0 }, "slow");
    //   // $(".reservation-back--1").addClass("d-n");
    //   // $(".reservation-back--2").removeClass("d-n");
    //   // $(".reservation-back--3").addClass("d-n");

    //   $(".reservation-step-hatch").removeClass("reservation-step-hatch--long");
    //   $(".reservation-undertitle--2").addClass("d-b");
    //   $(".reservation-undertitle--3").removeClass("d-b");

    //   $(".reservation-step-info").removeClass("d-b");
    //   $(".reservation-calc").removeClass("d-n");
    //   $(".hr").removeClass("d-n");
    //   $(".reservation-price").removeClass("d-b");
    //   $(".reservation-form--step3").addClass("d-n");
    //   $(".reservation-average").removeClass("d-b");
    //   $(".reservation-form--step2").addClass("d-b");

    //   $(".reservation-calc__button").unbind();
    //   $(".reservation-calc__button").click(function (event) {
    //     if (!($(event.currentTarget).hasClass("reservation-calc__button--disabled"))) {
    //       cardToStep3();
    //     }
    //   });
    //   let counter = $(".reservation-calc__counter-num").text();
    //   areInputsReady = true;

    //   $(".required-input-step-2").each(function (i, element) {
    //     if (!($(this).val().length > 0)) {
    //       areInputsReady = false;
    //     }
    //   });

    //   if (counter > 0 && areInputsReady) {
    //     $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
    //   } else {
    //     $(".reservation-calc__button").addClass("reservation-calc__button--disabled");
    //   }
    // }

    function fromStep3CardToStep1() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        // $(".reservation-back--1").removeClass("d-n");
        // $(".reservation-back--2").addClass("d-n");
        // $(".reservation-back--3").addClass("d-n");

        $(".reservation-step-hatch").removeClass("reservation-step-hatch--long");
        $(".reservation-undertitle--1").removeClass("d-n");
        $(".reservation-undertitle--3").removeClass("d-b");

        $(".reservation-form--step1").removeClass("d-n");
        $(".reservation-form--step2").addClass("d-b");
        $(".reservation-step-info").removeClass("d-b");
        $(".reservation-calc").removeClass("d-n");
        $(".hr").removeClass("d-n");
        $(".reservation-form--step2").removeClass("d-b");
        $(".reservation-price").removeClass("d-b");

        $(".reservation-calc__button").addClass("reservation-calc__button--disabled");
        $(".reservation-calc__button").unbind();
        $(".reservation-calc__button").click(function (event) {
            if (!($(event.currentTarget).hasClass("reservation-calc__button--disabled"))) {
                cardToStep2();
            }

            $(".reservation-popup-calc .reservation-popup__counter-plus").unbind();
            $(".reservation-popup-calc .reservation-popup__counter-plus").click(function() {
                let counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
                counter++;
                $(event.currentTarget).parent().children(".reservation-popup__counter-num").text(counter);
                if (isCompletedAddress && isCompletedDest) {
                    $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
                }
            });

            $(".reservation-calc__counter-plus").unbind();
            $(".reservation-calc__counter-plus").click(function (event) {
                let counter = $(event.currentTarget).parent().children(".reservation-calc__counter-num").text();
                //counter++;

                if (isCompletedAddress && isCompletedDest) {
                    $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
                }

                $(event.currentTarget).parent().children(".reservation-calc__counter-num").text(counter);
                // if (counter > 0) {
                //   $(".reservation-popup-calc").addClass("d-b");
                //   addOverlay($(".reservation-popup-calc"));
                // }
                $(".reservation-popup-calc").addClass("d-b");
                addMainOverlay($(".reservation-popup-calc"));
            });
        });
        let counter = $(".reservation-calc__counter-num").text();
        if (isCompletedAddress && isCompletedDest && counter > 0) {
            $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
        }
    }

    function fromStep3CardToStep1_address() {
        addressReturn();
        $("html, body").animate({ scrollTop: 0 }, "slow");
        // $(".reservation-back--1").removeClass("d-n");
        // $(".reservation-back--2").addClass("d-n");
        // $(".reservation-back--3").addClass("d-n");

        $(".reservation-step-hatch").removeClass("reservation-step-hatch--long");
        $(".reservation-undertitle--1").removeClass("d-n");
        $(".reservation-undertitle--3").removeClass("d-b");
        $(".reservation-form--step1").removeClass("d-n");
        $(".reservation-step-info").removeClass("d-b");
        $(".reservation-calc").removeClass("d-n");
        $(".hr").removeClass("d-n");
        $(".reservation-form--step2").removeClass("d-b");
        $(".reservation-price").removeClass("d-b");

        $(".reservation-calc__button").addClass("reservation-calc__button--disabled");
        $(".reservation-calc__button").unbind();
        $(".reservation-calc__button").click(function (event) {
            if (!($(event.currentTarget).hasClass("reservation-calc__button--disabled"))) {
                cardToStep2();
            }

            $(".reservation-popup-calc .reservation-popup__counter-plus").unbind();
            $(".reservation-popup-calc .reservation-popup__counter-plus").click(function() {
                let counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
                counter++;
                $(event.currentTarget).parent().children(".reservation-popup__counter-num").text(counter);
                if (isCompletedAddress && isCompletedDest) {
                    $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
                }
            });

            $(".reservation-calc__counter-plus").unbind();
            $(".reservation-calc__counter-plus").click(function (event) {
                let counter = $(event.currentTarget).parent().children(".reservation-calc__counter-num").text();
                //counter++;

                if (isCompletedAddress && isCompletedDest) {
                    $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
                }

                $(event.currentTarget).parent().children(".reservation-calc__counter-num").text(counter);
                // if (counter > 0) {
                //   $(".reservation-popup-calc").addClass("d-b");
                //   addOverlay($(".reservation-popup-calc"));
                // }
                $(".reservation-popup-calc").addClass("d-b");
                addMainOverlay($(".reservation-popup-calc"));
            });
        });
    }

    function fromStep3CardToStep1_dest() {
        destReturn();
        $("html, body").animate({ scrollTop: 0 }, "slow");
        // $(".reservation-back--1").removeClass("d-n");
        // $(".reservation-back--2").addClass("d-n");
        // $(".reservation-back--3").addClass("d-n");

        $(".reservation-step-hatch").removeClass("reservation-step-hatch--long");
        $(".reservation-undertitle--1").removeClass("d-n");
        $(".reservation-undertitle--3").removeClass("d-b");
        $(".reservation-form--step1").removeClass("d-n");
        $(".reservation-step-info").removeClass("d-b");
        $(".reservation-calc").removeClass("d-n");
        $(".hr").removeClass("d-n");
        $(".reservation-form--step2").removeClass("d-b");
        $(".reservation-price").removeClass("d-b");

        $(".reservation-calc__button").addClass("reservation-calc__button--disabled");
        $(".reservation-calc__button").unbind();
        $(".reservation-calc__button").click(function (event) {
            if (!($(event.currentTarget).hasClass("reservation-calc__button--disabled"))) {
                cardToStep2();
            }

            $(".reservation-popup-calc .reservation-popup__counter-plus").unbind();
            $(".reservation-popup-calc .reservation-popup__counter-plus").click(function() {
                let counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
                counter++;
                $(event.currentTarget).parent().children(".reservation-popup__counter-num").text(counter);
                if (isCompletedAddress && isCompletedDest) {
                    $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
                }
            });

            $(".reservation-calc__counter-plus").unbind();
            $(".reservation-calc__counter-plus").click(function (event) {
                let counter = $(event.currentTarget).parent().children(".reservation-calc__counter-num").text();
                //counter++;

                if (isCompletedAddress && isCompletedDest) {
                    $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
                }

                $(event.currentTarget).parent().children(".reservation-calc__counter-num").text(counter);
                // if (counter > 0) {
                //   $(".reservation-popup-calc").addClass("d-b");
                //   addOverlay($(".reservation-popup-calc"))
                // }
                $(".reservation-popup-calc").addClass("d-b");
                addMainOverlay($(".reservation-popup-calc"));
            });
        });
    }

    function cardToStep2() {
        $("html, body").animate({ scrollTop: 0 }, "slow");

        // $(".reservation-back--1").addClass("d-n");
        // $(".reservation-back--2").removeClass("d-n");
        // $(".reservation-back--3").addClass("d-n");

        $(".reservation-undertitle--1").addClass("d-n");
        $(".reservation-undertitle--2").addClass("d-b");
        $(".reservation-form--step2").addClass("d-b");
        $(".reservation-form--step1").addClass("d-n");
        $(".reservation-average").removeClass("d-b");
        $(".reservation-calc__button").addClass("reservation-calc__button--disabled");

        $(".reservation-calc__button").unbind();
        $(".reservation-calc__button").click(function (event) {
            if (!($(event.currentTarget).hasClass("reservation-calc__button--disabled"))) {
                cardToStep3();
            }
        });

        $(".reservation-calc__counter-plus").unbind();
        $(".reservation-popup-calc .reservation-popup__counter-plus").unbind();
        let areInputsReady = false;

        let counter = $(".reservation-calc__counter-num").text();
        areInputsReady = true;

        $(".required-input-step-2").each(function (i, element) {
            if (!($(this).val().length > 0)) {
                areInputsReady = false;
            }
        });

        if (counter > 0 && areInputsReady) {
            $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
        } else {
            $(".reservation-calc__button").addClass("reservation-calc__button--disabled");
        }

        $(".reservation-calc__counter-plus").click(function () {
            let counter = $(event.currentTarget).parent().children(".reservation-calc__counter-num").text();
            //counter++;
            $(event.currentTarget).parent().children(".reservation-calc__counter-num").text(counter);

            // if (counter > 0) {
            //   $(".reservation-popup-calc").addClass("d-b");
            //   addOverlay($(".reservation-popup-calc"));
            // }
            $(".reservation-popup-calc").addClass("d-b");
            addOverlay($(".reservation-popup-calc"));

            if (areInputsReady) {
                $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
            }
        });

        $(".reservation-popup-calc .reservation-popup__counter-plus").click(function() {
            let counter = $(event.currentTarget).parent().children(".reservation-popup__counter-num").text();
            counter++;
            $(event.currentTarget).parent().children(".reservation-popup__counter-num").text(counter);
            calcCounter = $(".reservation-calc__counter-num").text();
            calcCounter++;
            $(".reservation-calc__counter-num").text(calcCounter)
            if (areInputsReady) {
                $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
            }
        });

        $(".required-input-step-2").change(function () {
            let counter = $(".reservation-calc__counter-num").text();
            areInputsReady = true;

            $(".required-input-step-2").each(function (i, element) {
                if (!($(this).val().length > 0)) {
                    areInputsReady = false;
                }
            });

            if (counter > 0 && areInputsReady) {
                $(".reservation-calc__button").removeClass("reservation-calc__button--disabled");
            } else {
                $(".reservation-calc__button").addClass("reservation-calc__button--disabled");
            }
        });
    }

    function cardToStep3() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        // $(".reservation-back--1").addClass("d-n");
        // $(".reservation-back--2").addClass("d-n");
        // $(".reservation-back--3").removeClass("d-n");

        $(".reservation-undertitle--1").addClass("d-n");
        $(".reservation-undertitle--2").removeClass("d-b");
        $(".reservation-undertitle--3").addClass("d-b");
        $(".reservation-form--step2").removeClass("d-b");
        $(".reservation-form--step3").removeClass("d-n");
        $(".reservation-step-info").addClass("d-b");
        $(".reservation-step-hatch").addClass("reservation-step-hatch--long");
        $(".reservation-price").addClass("d-b");
        $(".hr").addClass("d-n");
        $(".reservation-calc__button").addClass("reservation-calc__button--disabled");

        $(".reservation-calc").addClass("d-n");
    }

    //Reservation tabs
    $(".reservation-tab--second").click(function(event) {
        $(".reservation-tab--first").removeClass("reservation-tab--active");
        $(".reservation-tab--second").addClass("reservation-tab--active");
        $(".reservation-content").addClass("d-n");
        $(".reservation-services").addClass("d-b");
    });

    $(".reservation-tab--first").click(function(event) {
        $(".reservation-tab--second").removeClass("reservation-tab--active");
        $(".reservation-tab--first").addClass("reservation-tab--active");
        $(".reservation-content").removeClass("d-n");
        $(".reservation-services").removeClass("d-b");
    });
});
