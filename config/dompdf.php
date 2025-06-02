<?php
return [
    'show_warnings' => false,
    'public_path' => null,
    'convert_entities' => true,
    
    'options' => [
        'font_dir' => storage_path('fonts/'),
        'font_cache' => storage_path('fonts/'),
        'temp_dir' => sys_get_temp_dir(),
        'chroot' => realpath(base_path()),
        'default_font' => 'serif',
        
        'enable_remote' => false,
        'enable_php' => false,
        'enable_javascript' => false,
        'enable_html5_parser' => false, // Ubah ke false untuk kompatibilitas
        'enable_font_subsetting' => false,
        
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'default_paper_orientation' => 'portrait',
        'dpi' => 96,
        
        // Opsi untuk mencegah error
        'debugPng' => false,
        'debugKeepTemp' => false,
        'debugCss' => false,
        'debugLayout' => false,
        'debugLayoutLines' => false,
        'debugLayoutBlocks' => false,
        'debugLayoutInline' => false,
        'debugLayoutPaddingBox' => false,
    ],
];