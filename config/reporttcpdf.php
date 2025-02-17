<?php

return [
    // Font directory
    'K_PATH_FONTS' => base_path('vendor/tecnickcom/tcpdf/fonts'),

    // Image directory (adjust this to your actual image directory)
    'K_PATH_IMAGES' => base_path('public/img'),

    // Paper size (A4, Letter, etc.)
    'K_PAPER_SIZE' => 'A4',

    // Paper unit (mm, cm, in)
    'K_PAPER_UNIT' => 'mm',

    // Paper format (portrait, landscape)
    'K_PAPER_FORMAT' => 'P',

    // Font settings (adjust these as needed)
    'PDF_FONT_NAME_MAIN' => 'helvetica',
    'PDF_FONT_SIZE_MAIN' => 10,
    'PDF_FONT_NAME_DATA' => 'helvetica',
    'PDF_FONT_SIZE_DATA' => 8,

    // Other TCPDF configuration options (refer to the TCPDF documentation for more options)
    // ...
];