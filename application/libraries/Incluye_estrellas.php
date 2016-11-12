<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class incluye_estrellas{

    public function __construct(){
    }

    public function put_estrellas(){
        $estrellas_menu ="";
        $estrellas_menu .= "<script src='".base_url('assets/js/rater.min.js')."' charset='utf-8'></script>";
        $estrellas_menu .= <<<EOT

    <style>
        .rating_precio
        {
            font-size: 35px;
        }
        .rating_precio .rate-hover-layer
        {
            color: red;
        }
        .rating_precio .rate-select-layer
        {
            color: green;
        }

        .rating_calidad
        {
            font-size: 35px;
        }
        .rating_calidad .rate-hover-layer
        {
            color: red;
        }
        .rating_calidad .rate-select-layer
        {
            color: orange;
        }
        #PsromedioNota{
            font-size: 41px
        }
        .justifica{
                display: flex;
                justify-content:space-around;
        }

    </style>

<script>
$(document).ready(function(){
var options_calidad = {
    max_value: 5,
    step_size: 0.5,
    initial_value: 0,
    symbols: {
            utf8_fork: {
                base: '\xF0\x9F\x8D\x94',
                hover: '\xF0\x9F\x8D\x94',
                selected: '\xF0\x9F\x8D\x94',
            },
            utf8_emoticons: {
                base: [0x1F625, 0x1F613, 0x1F612, 0x1F604],
                hover: [0x1F625, 0x1F613, 0x1F612, 0x1F604],
                selected: [0x1F625, 0x1F613, 0x1F612, 0x1F604],
            },
        },
    selected_symbol_type: 'utf8_fork', // Must be a key from symbols
    cursor: 'default',
    readonly: false,
    change_once: false, // Determines if the rating can only be set once
}

var options_precio = {
    max_value: 5,
    step_size: 0.5,
    initial_value: 0,
    symbols: {
            utf8_dinero: {
                base: '\xF0\x9F\x92\xB5',
                hover: '\xF0\x9F\x92\xB5',
                selected: '\xF0\x9F\x92\xB5',
            },
            utf8_emoticons: {
                base: [0x1F625, 0x1F613, 0x1F612, 0x1F604],
                hover: [0x1F625, 0x1F613, 0x1F612, 0x1F604],
                selected: [0x1F625, 0x1F613, 0x1F612, 0x1F604],
            },
        },
    selected_symbol_type: 'utf8_dinero', // Must be a key from symbols
    cursor: 'default',
    readonly: false,
    change_once: false, // Determines if the rating can only be set once
}

$(".rating_calidad").rate(options_calidad);
$(".rating_precio").rate(options_precio);
})
</script>

EOT;

        return $estrellas_menu;
    }
}
?>
