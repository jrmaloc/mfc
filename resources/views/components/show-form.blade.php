@props ([
    'section' => '',
    'editRoute' => '',
    'tithes' => '',
    'age' => '',
    'role' => '',
    'events' => '',

])

@extends('layout.layout')

@section('head')
    <style>
        [tabindex='-1']:focus {
            outline: 0 !important;
        }

        hr {
            overflow: visible;
            box-sizing: content-box;
            height: 0;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        address {
            font-style: normal;
            line-height: inherit;
            margin-bottom: 1rem;
        }

        ul {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        ul ul {
            margin-bottom: 0;
        }

        dfn {
            font-style: italic;
        }

        strong {
            font-weight: bolder;
        }

        a {
            text-decoration: none;
            color: #5e72e4;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }

        a:hover {
            text-decoration: none;
            color: #233dd2;
        }

        a:not([href]):not([tabindex]) {
            text-decoration: none;
            color: inherit;
        }

        a:not([href]):not([tabindex]):hover,
        a:not([href]):not([tabindex]):focus {
            text-decoration: none;
            color: inherit;
        }

        a:not([href]):not([tabindex]):focus {
            outline: 0;
        }

        code {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
            font-size: 1em;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        caption {
            padding-top: 1rem;
            padding-bottom: 1rem;
            caption-side: bottom;
            text-align: left;
            color: #8898aa;
        }

        label {
            display: inline-block;
            margin-bottom: .5rem;
        }

        button {
            border-radius: 0;
        }

        button:focus {
            outline: 1px dotted;
            outline: 5px auto -webkit-focus-ring-color;
        }

        input,
        button,
        textarea {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
            margin: 0;
        }

        button,
        input {
            overflow: visible;
        }

        button {
            text-transform: none;
        }

        button,
        html [type='button'],
        [type='reset'],
        [type='submit'] {
            -webkit-appearance: button;
        }

        button::-moz-focus-inner,
        [type='button']::-moz-focus-inner,
        [type='reset']::-moz-focus-inner,
        [type='submit']::-moz-focus-inner {
            padding: 0;
            border-style: none;
        }

        input[type='radio'],
        input[type='checkbox'] {
            box-sizing: border-box;
            padding: 0;
        }

        input[type='date'],
        input[type='time'],
        input[type='datetime-local'],
        input[type='month'] {
            -webkit-appearance: listbox;
        }

        textarea {
            overflow: auto;
            resize: vertical;
        }

        legend {
            font-size: 1.5rem;
            line-height: inherit;
            display: block;
            width: 100%;
            max-width: 100%;
            margin-bottom: .5rem;
            padding: 0;
            white-space: normal;
            color: inherit;
        }

        progress {
            vertical-align: baseline;
        }

        [type='number']::-webkit-inner-spin-button,
        [type='number']::-webkit-outer-spin-button {
            height: auto;
        }

        [type='search'] {
            outline-offset: -2px;
            -webkit-appearance: none;
        }

        [type='search']::-webkit-search-cancel-button,
        [type='search']::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        ::-webkit-file-upload-button {
            font: inherit;
            -webkit-appearance: button;
        }

        [hidden] {
            display: none !important;
        }

        .h1,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: inherit;
            font-weight: 600;
            line-height: 1.5;
            margin-bottom: .5rem;
            color: #32325d;
        }

        .h1 {
            font-size: 1.625rem;
        }

        .h3 {
            font-size: 1.0625rem;
        }

        .h4 {
            font-size: .9375rem;
        }

        .h5 {
            font-size: .8125rem;
        }

        .h6 {
            font-size: .625rem;
        }

        .display-2 {
            font-size: 2.75rem;
            font-weight: 600;
            line-height: 1.5;
        }

        hr {
            margin-top: 2rem;
            margin-bottom: 2rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        code {
            font-size: 87.5%;
            word-break: break-word;
            color: #f3a4b5;
        }

        a>code {
            color: inherit;
        }

        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
        }

        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .container {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }

        .container-fluid {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
        }

        .row {
            display: flex;
            margin-right: -15px;
            margin-left: -15px;
            flex-wrap: wrap;
        }

        .col-4,
        .col-8,
        .col,
        .col-md-10,
        .col-md-12,
        .col-lg-3,
        .col-lg-4,
        .col-lg-6,
        .col-lg-7,
        .col-xl-4,
        .col-xl-6,
        .col-xl-8 {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col {
            max-width: 100%;
            flex-basis: 0;
            flex-grow: 1;
        }

        .col-4 {
            max-width: 33.33333%;
            flex: 0 0 33.33333%;
        }

        .col-8 {
            max-width: 66.66667%;
            flex: 0 0 66.66667%;
        }

        @media (min-width: 768px) {

            .col-md-10 {
                max-width: 83.33333%;
                flex: 0 0 83.33333%;
            }

            .col-md-12 {
                max-width: 100%;
                flex: 0 0 100%;
            }
        }

        @media (min-width: 992px) {

            .col-lg-3 {
                max-width: 25%;
                flex: 0 0 25%;
            }

            .col-lg-4 {
                max-width: 33.33333%;
                flex: 0 0 33.33333%;
            }

            .col-lg-6 {
                max-width: 50%;
                flex: 0 0 50%;
            }

            .col-lg-7 {
                max-width: 58.33333%;
                flex: 0 0 58.33333%;
            }

            .order-lg-2 {
                order: 2;
            }
        }

        @media (min-width: 1200px) {

            .col-xl-4 {
                max-width: 33.33333%;
                flex: 0 0 33.33333%;
            }

            .col-xl-6 {
                max-width: 50%;
                flex: 0 0 50%;
            }

            .col-xl-8 {
                max-width: 66.66667%;
                flex: 0 0 66.66667%;
            }

            .order-xl-1 {
                order: 1;
            }

            .order-xl-2 {
                order: 2;
            }
        }

        .form-control {
            font-size: 1rem;
            line-height: 1.5;
            display: block;
            width: 100%;
            height: calc(2.75rem + 2px);
            padding: .625rem .75rem;
            transition: all .2s cubic-bezier(.68, -.55, .265, 1.55);
            color: #8898aa;
            border: 1px solid #cad1d7;
            border-radius: .375rem;
            background-color: #fff;
            background-clip: padding-box;
            box-shadow: none;
        }

        @media screen and (prefers-reduced-motion: reduce) {
            .form-control {
                transition: none;
            }
        }

        .form-control::-ms-expand {
            border: 0;
            background-color: transparent;
        }

        .form-control:focus {
            color: #8898aa;
            border-color: #9055fd !important;
            outline: 0;
            background-color: #fff;
            box-shadow: none, none;
        }

        .form-control:-ms-input-placeholder {
            opacity: 1;
            color: #adb5bd;
        }

        .form-control::-ms-input-placeholder {
            opacity: 1;
            color: #adb5bd;
        }

        .form-control::placeholder {
            opacity: 1;
            color: #adb5bd;
        }

        textarea.form-control {
            height: auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-inline {
            display: flex;
            flex-flow: row wrap;
            align-items: center;
        }

        @media (min-width: 576px) {
            .form-inline label {
                display: flex;
                margin-bottom: 0;
                align-items: center;
                justify-content: center;
            }

            .form-inline .form-group {
                display: flex;
                margin-bottom: 0;
                flex: 0 0 auto;
                flex-flow: row wrap;
                align-items: center;
            }

            .form-inline .form-control {
                display: inline-block;
                width: auto;
                vertical-align: middle;
            }

            .form-inline .input-group {
                width: auto;
            }
        }

        .btn {
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.5;
            display: inline-block;
            padding: .625rem 1.25rem;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            border: 1px solid transparent;
            border-radius: .375rem;
        }

        @media screen and (prefers-reduced-motion: reduce) {
            .btn {
                transition: none;
            }
        }

        .btn:hover,
        .btn:focus {
            text-decoration: none;
        }

        .btn:focus {
            outline: 0;
            box-shadow: 0 7px 14px rgba(50, 50, 93, .1), 0 3px 6px rgba(0, 0, 0, .08);
        }

        .btn:disabled {
            opacity: .65;
            box-shadow: none;
        }

        .btn:not(:disabled):not(.disabled) {
            cursor: pointer;
        }

        .btn:not(:disabled):not(.disabled):active {
            box-shadow: none;
        }

        .btn:not(:disabled):not(.disabled):active:focus {
            box-shadow: 0 7px 14px rgba(50, 50, 93, .1), 0 3px 6px rgba(0, 0, 0, .08), none;
        }

        .btn-primary {
            color: #fff;
            border-color: #5e72e4;
            background-color: #5e72e4;
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
        }

        .btn-primary:hover {
            color: #fff;
            border-color: #5e72e4;
            background-color: #5e72e4;
        }

        .btn-primary:focus {
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 0 rgba(94, 114, 228, .5);
        }

        .btn-primary:disabled {
            color: #fff;
            border-color: #5e72e4;
            background-color: #5e72e4;
        }

        .btn-primary:not(:disabled):not(.disabled):active {
            color: #fff;
            border-color: #5e72e4;
            background-color: #324cdd;
        }

        .btn-primary:not(:disabled):not(.disabled):active:focus {
            box-shadow: none, 0 0 0 0 rgba(94, 114, 228, .5);
        }

        .btn-info {
            color: #fff;
            border-color: #11cdef;
            background-color: #11cdef;
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
        }

        .btn-info:hover {
            color: #fff;
            border-color: #11cdef;
            background-color: #11cdef;
        }

        .btn-info:focus {
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 0 rgba(17, 205, 239, .5);
        }

        .btn-info:disabled {
            color: #fff;
            border-color: #11cdef;
            background-color: #11cdef;
        }

        .btn-info:not(:disabled):not(.disabled):active {
            color: #fff;
            border-color: #11cdef;
            background-color: #0da5c0;
        }

        .btn-info:not(:disabled):not(.disabled):active:focus {
            box-shadow: none, 0 0 0 0 rgba(17, 205, 239, .5);
        }

        .btn-default {
            color: #fff;
            border-color: #172b4d;
            background-color: #172b4d;
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
        }

        .btn-default:hover {
            color: #fff;
            border-color: #172b4d;
            background-color: #172b4d;
        }

        .btn-default:focus {
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 0 rgba(23, 43, 77, .5);
        }

        .btn-default:disabled {
            color: #fff;
            border-color: #172b4d;
            background-color: #172b4d;
        }

        .btn-default:not(:disabled):not(.disabled):active {
            color: #fff;
            border-color: #172b4d;
            background-color: #0b1526;
        }

        .btn-default:not(:disabled):not(.disabled):active:focus {
            box-shadow: none, 0 0 0 0 rgba(23, 43, 77, .5);
        }

        .btn-sm {
            font-size: .875rem;
            line-height: 1.5;
            padding: .25rem .5rem;
            border-radius: .375rem;
        }

        .input-group {
            position: relative;
            display: flex;
            width: 100%;
            flex-wrap: wrap;
            align-items: stretch;
        }

        .input-group>.form-control {
            position: relative;
            width: 1%;
            margin-bottom: 0;
            flex: 1 1 auto;
        }

        .input-group>.form-control+.form-control {
            margin-left: -1px;
        }

        .input-group>.form-control:focus {
            z-index: 3;
        }

        .input-group>.form-control:not(:last-child) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group>.form-control:not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group-prepend {
            display: flex;
        }

        .input-group-prepend .btn {
            position: relative;
            z-index: 2;
        }

        .input-group-prepend .btn+.btn,
        .input-group-prepend .btn+.input-group-text,
        .input-group-prepend .input-group-text+.input-group-text,
        .input-group-prepend .input-group-text+.btn {
            margin-left: -1px;
        }

        .input-group-prepend {
            margin-right: -1px;
        }

        .input-group-text {
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            display: flex;
            margin-bottom: 0;
            padding: .625rem .75rem;
            text-align: center;
            white-space: nowrap;
            color: #adb5bd;
            border: 1px solid #cad1d7;
            border-radius: .375rem;
            background-color: #fff;
            align-items: center;
        }

        .input-group-text input[type='radio'],
        .input-group-text input[type='checkbox'] {
            margin-top: 0;
        }

        .input-group>.input-group-prepend>.btn,
        .input-group>.input-group-prepend>.input-group-text {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group>.input-group-prepend:not(:first-child)>.btn,
        .input-group>.input-group-prepend:not(:first-child)>.input-group-text,
        .input-group>.input-group-prepend:first-child>.btn:not(:first-child),
        .input-group>.input-group-prepend:first-child>.input-group-text:not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            border: 1px solid rgba(0, 0, 0, .05);
            border-radius: .375rem;
            background-color: #fff;
            background-clip: border-box;
        }

        .card>hr {
            margin-right: 0;
            margin-left: 0;
        }

        .card-body {
            padding: 1.5rem;
            flex: 1 1 auto;
        }

        .card-header {
            margin-bottom: 0;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            background-color: #fff;
        }

        .card-header:first-child {
            border-radius: calc(.375rem - 1px) calc(.375rem - 1px) 0 0;
        }

        @keyframes progress-bar-stripes {
            from {
                background-position: 1rem 0;
            }

            to {
                background-position: 0 0;
            }
        }

        .media {
            display: flex;
            align-items: flex-start;
        }

        .media-body {
            flex: 1 1;
        }

        .bg-secondary {
            background-color: #f7fafc !important;
        }

        a.bg-secondary:hover,
        a.bg-secondary:focus,
        button.bg-secondary:hover,
        button.bg-secondary:focus {
            background-color: #d2e3ee !important;
        }

        .bg-default {
            background-color: #172b4d !important;
        }

        a.bg-default:hover,
        a.bg-default:focus,
        button.bg-default:hover,
        button.bg-default:focus {
            background-color: #0b1526 !important;
        }

        .bg-white {
            background-color: #fff !important;
        }

        a.bg-white:hover,
        a.bg-white:focus,
        button.bg-white:hover,
        button.bg-white:focus {
            background-color: #e6e6e6 !important;
        }

        .bg-white {
            background-color: #fff !important;
        }

        .border-0 {
            border: 0 !important;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .d-none {
            display: none !important;
        }

        .d-flex {
            display: flex !important;
        }

        @media (min-width: 768px) {

            .d-md-flex {
                display: flex !important;
            }
        }

        @media (min-width: 992px) {

            .d-lg-inline-block {
                display: inline-block !important;
            }

            .d-lg-block {
                display: block !important;
            }
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        @media (min-width: 1200px) {

            .justify-content-xl-between {
                justify-content: space-between !important;
            }
        }

        .float-right {
            float: right !important;
        }

        .shadow,
        .card-profile-image img {
            box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15) !important;
        }

        .m-0 {
            margin: 0 !important;
        }

        .mt-0 {
            margin-top: 0 !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .mr-2 {
            margin-right: .5rem !important;
        }

        .ml-2 {
            margin-left: .5rem !important;
        }

        .mr-3 {
            margin-right: 1rem !important;
        }

        .mt-4,
        .my-4 {
            margin-top: 1.5rem !important;
        }

        .mr-4 {
            margin-right: 1.5rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .mt--7 {
            margin-top: -6rem !important;
        }

        .pt-0 {
            padding-top: 0 !important;
        }

        .pr-0 {
            padding-right: 0 !important;
        }

        .pb-0 {
            padding-bottom: 0 !important;
        }

        .pt-5 {
            padding-top: 3rem !important;
        }

        .pt-8 {
            padding-top: 8rem !important;
        }

        .pb-8 {
            padding-bottom: 8rem !important;
        }

        .m-auto {
            margin: auto !important;
        }

        @media (min-width: 768px) {

            .mt-md-5 {
                margin-top: 3rem !important;
            }

            .pt-md-4 {
                padding-top: 1.5rem !important;
            }

            .pb-md-4 {
                padding-bottom: 1.5rem !important;
            }
        }

        @media (min-width: 992px) {

            .pl-lg-4 {
                padding-left: 1.5rem !important;
            }

            .pt-lg-8 {
                padding-top: 8rem !important;
            }

            .ml-lg-auto {
                margin-left: auto !important;
            }
        }

        @media (min-width: 1200px) {

            .mb-xl-0 {
                margin-bottom: 0 !important;
            }
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .font-weight-light {
            font-weight: 300 !important;
        }

        .font-weight-bold {
            font-weight: 600 !important;
        }

        .text-white {
            color: #fff !important;
        }

        .text-white {
            color: #fff !important;
        }

        a.text-white:hover,
        a.text-white:focus {
            color: #e6e6e6 !important;
        }

        .text-muted {
            color: #8898aa !important;
        }

        @media print {

            *,
            *::before,
            *::after {
                box-shadow: none !important;
                text-shadow: none !important;
            }

            a:not(.btn) {
                text-decoration: underline;
            }

            img {
                page-break-inside: avoid;
            }

            p,
            h3 {
                orphans: 3;
                widows: 3;
            }

            h3 {
                page-break-after: avoid;
            }

            @ page {
                size: a3;
            }

            body {
                min-width: 992px !important;
            }

            .container {
                min-width: 992px !important;
            }

            .navbar {
                display: none;
            }
        }

        figcaption,
        main {
            display: block;
        }

        main {
            overflow: hidden;
        }

        .bg-white {
            background-color: #fff !important;
        }

        a.bg-white:hover,
        a.bg-white:focus,
        button.bg-white:hover,
        button.bg-white:focus {
            background-color: #e6e6e6 !important;
        }

        .bg-gradient-default {
            background: linear-gradient(87deg, #172b4d 0, #1a174d 100%) !important;
        }

        .bg-gradient-default {
            background: linear-gradient(87deg, #172b4d 0, #1a174d 100%) !important;
        }

        .card-profile-image {
            position: relative;
        }

        .card-profile-image img {
            position: absolute;
            left: 50%;
            max-width: 180px;
            transition: all .15s ease;
            transform: translate(-50%, -30%);
            border-radius: .375rem;
        }

        .card-profile-image img:hover {
            transform: translate(-50%, -33%);
        }

        .card-profile-stats {
            padding: 1rem 0;
        }

        .card-profile-stats>div {
            margin-right: 1rem;
            padding: .875rem;
            text-align: center;
        }

        .card-profile-stats>div:last-child {
            margin-right: 0;
        }

        .card-profile-stats>div .heading {
            font-size: 1.1rem;
            font-weight: bold;
            display: block;
        }

        .card-profile-stats>div .description {
            font-size: .875rem;
            color: #adb5bd;
        }

        .main-content {
            position: relative;
        }

        @media (min-width: 768px) {
            .main-content .container-fluid {
                padding-right: 39px !important;
                padding-left: 39px !important;
            }
        }

        .form-control-label {
            font-size: .875rem;
            font-weight: 600;
            color: #525f7f;
        }

        .form-control {
            font-size: .875rem;
        }

        .form-control:focus:-ms-input-placeholder {
            color: #adb5bd;
        }

        .form-control:focus::-ms-input-placeholder {
            color: #adb5bd;
        }

        .form-control:focus::placeholder {
            color: #adb5bd;
        }

        textarea[resize='none'] {
            resize: none !important;
        }

        textarea[resize='both'] {
            resize: both !important;
        }

        textarea[resize='vertical'] {
            resize: vertical !important;
        }

        textarea[resize='horizontal'] {
            resize: horizontal !important;
        }

        .form-control-alternative {
            transition: box-shadow .15s ease;
            border: 0;
            box-shadow: 0 1px 3px rgba(50, 50, 93, .15), 0 1px 0 rgba(0, 0, 0, .02);
        }

        .form-control-alternative:focus {
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
        }

        .focused .form-control {
            border-color: rgba(50, 151, 211, .25);
        }

        .header {
            position: relative;
        }

        .focused .form-control {
            border-color: rgba(50, 151, 211, .25);
        }

        .mask {
            position: absolute;
            top: 30px;
            left: 0;
            width: 100%;
            height: 100%;
            transition: all .15s ease;
        }

        @media screen and (prefers-reduced-motion: reduce) {
            .mask {
                transition: none;
            }
        }

        p {
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.7;
        }

        .description {
            font-size: .875rem;
        }

        .heading {
            font-size: .95rem;
            font-weight: 600;
            letter-spacing: .025em;
            text-transform: uppercase;
        }

        .heading-small {
            font-size: .75rem;
            padding-top: .25rem;
            padding-bottom: .25rem;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .display-2 span {
            font-weight: 300;
            display: block;
        }

        @media (max-width: 768px) {
            .btn {
                margin-bottom: 10px;
            }
        }

        .rounded-top {
            border-top-left-radius: 1.3125rem !important;
            border-top-right-radius: 1.3125rem !important;
        }
    </style>
@endsection

@section('content')
    <div class="main-content" style="margin-left: 5%; margin-right: 5%;">
        <!-- Header -->
        <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
            style="min-height: 600px; background-size: cover; background-position: center top;">
            <!-- Mask -->
            <span class="mask bg-gradient-default opacity-8 rounded-top"></span>
            <!-- Header container -->
            <div class="container-fluid d-flex align-items-center justify-end" style="position: absolute; bottom: 20%;">
                <div class="row">
                    <div class="col-lg-7 col-md-10">
                        <a href="{{ $editRoute }}" class="btn btn-primary">Edit profile
                            <!-- https://feathericons.dev/?search=edit&iconset=feather -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"
                                class="main-grid-item-icon ml-2" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt-7">
            {{ $slot }}
            <div class="row">
                <div class="col-xl-4 order-xl-1 mb-5 mb-xl-0">
                    <div class="card card-profile shadow">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        @isset($section->avatar)
                                        <img src="{{ URL::asset($section->avatar) }}" id="avatar"
                                        class="rounded-circle">
                                        @else
                                        <img src="{{ URL::asset('assets/img/avatars/3.png') }}" id="avatar"
                                                class="rounded-circle">
                                        @endisset
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4"></div>
                        <div class="card-body pt-0 pt-md-4">
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                        <div>
                                            <span class="heading">{{ $tithes }}</span>
                                            <span class="description">Tithes</span>
                                        </div>
                                        <div>
                                            <span class="heading">{{ $events }}</span>
                                            <span class="description">Events</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                @if ($section->nickname)
                                    <h3 class="capitalize">
                                        {{ $section->nickname }}<span class="font-weight-light">, {{ $age }}</span>
                                    </h3>
                                @else
                                    <h3 class="capitalize">
                                        {{ $section->name }}<span class="font-weight-light">, {{ $age }}</span>
                                    </h3>
                                @endif
                                <div class="h3 font-weight-300">
                                    <i class="ni location_pin mr-2"></i>{{ $role->name }}
                                </div>
                                <hr class="my-4">
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input disabled value="Active" class="form-check-input form-control mr-2" name="status"
                                    type="checkbox" style="width: 38px; height: 20px;" id="status"
                                    @if ($section->status == 'Active') checked @endif
                                    @if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2) disabled @endif />
                                <label class="form-check-label" for="status">is Active</label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input disabled value="Active" class="form-check-input form-control mr-2" name="verifyEmail"
                                    type="checkbox" style="width: 38px; height: 20px;" id="verifyEmail"
                                    @if ($section->email_verified_at) checked @endif />
                                <label class="form-check-label" for="verifyEmail">Email Verified</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 order-xl-2">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">My account</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form>
                                <h6 class="heading-small text-muted mb-4">User information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-name">Full
                                                    name</label>
                                                <input type="text" id="input-name"
                                                    class="form-control form-control-alternative" placeholder="name"
                                                    @if ($section->name) value="{{ $section->name }}"
                                                    @else
                                                        value="" @endif
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-email">Email address</label>
                                                <input type="email" id="input-email"
                                                    class="form-control form-control-alternative"
                                                    placeholder="example@email.com"
                                                    @if ($section->email) value="{{ $section->email }}"
                                                    @else
                                                        value="" @endif
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-username">Username</label>
                                                <input type="text" id="input-username"
                                                    class="form-control form-control-alternative" placeholder="@ Username"
                                                    @if ($section->username) value="@ {{ $section->username }}"
                                                    @else
                                                        value="" @endif
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-gender">Gender</label>
                                                <input type="text" id="input-gender"
                                                    class="form-control form-control-alternative" name="gender"
                                                    placeholder="name"
                                                    @if ($section->gender) value="{{ $section->gender }}"
                                                    @else
                                                        value="" @endif
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Contact information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-address">Full Address</label>
                                                <input id="input-address" class="form-control form-control-alternative"
                                                    placeholder="Home Address"
                                                    @if ($section->address) value="{{ $section->address }}"
                                                    @else
                                                        value="" @endif
                                                    type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-last-name">Phone
                                                    Number</label>
                                                <input type="tel" id="input-last-name"
                                                    class="form-control form-control-alternative" name="contact_number"
                                                    placeholder="09********"
                                                    @if ($section->contact_number) value="{{ $section->contact_number }}"
                                                    @else
                                                        value="" @endif
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-area">Area</label>
                                                <input type="text" id="input-area"
                                                    class="form-control form-control-alternative" placeholder="Country"
                                                    @if ($section->area) value="{{ $section->area }}"
                                                    @else
                                                        value="" @endif
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-chapter">Chapter</label>
                                                <input type="text" id="input-chapter"
                                                    class="form-control form-control-alternative" placeholder=""
                                                    @if ($section->chapter) value="{{ $section->chapter }}"
                                                    @else
                                                        value="" @endif
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <!-- Description -->
                                <h6 class="heading-small text-muted mb-3">About me</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group focused">
                                        <textarea readonly id="input-bio" rows="4" class="form-control form-control-alternative" placeholder=""></textarea>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var bio = @json($section->bio); // Convert PHP variable to JSON format
                                            var inputBio = document.getElementById('input-bio');

                                            if (bio) {
                                                inputBio.value = bio;
                                            } else {
                                                inputBio.value = 'A few words about you...';
                                            }
                                        });
                                    </script>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#upload').change(function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $('#uploadedAvatar').attr('src', event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
