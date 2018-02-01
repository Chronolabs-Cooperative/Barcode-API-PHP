## Chronolabs Cooperative presents

# Barcodes Generation REST API v1.1.2

#### Demo: http://barcodes.snails.email

### Author: Simon Antony Roberts <simon@snails.email>

The following REST API allows for images over 14 barcode types to be generated for the purpose of inclusion in TCPDF or images for the result of assigning a barcode to any resource via API, you can also with this generate barcodes for tattooing which really scan they are scalar in perspective stretches both in height and width and still works!

## Barcodes Supported

These are the barcode codes which are supported by the API

    C39  -  CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9
    C39+  -  CODE 39 with checksum
    C39E  -  CODE 39 EXTENDED
    C39E+  -  CODE 39 EXTENDED + CHECKSUM
    C93  -  CODE 93 - USS-93
    S25  -  Standard 2 of 5
    S25+  -  Standard 2 of 5 + CHECKSUM
    I25  -  Interleaved 2 of 5
    I25+  -  Interleaved 2 of 5 + CHECKSUM
    C128  -  CODE 128
    C128A  -  CODE 128 A
    C128B  -  CODE 128 B
    C128C  -  CODE 128 C
    EAN2  -  2-Digits UPC-Based Extension
    EAN5  -  5-Digits UPC-Based Extension
    EAN8  -  EAN 8
    EAN13  -  EAN 13
    UPCA  -  UPC-A
    UPCE  -  UPC-E
    MSI  -  MSI (Variation of Plessey code)
    MSI+  -  MSI + CHECKSUM (modulo 11)
    POSTNET  -  POSTNET
    PLANET  -  PLANET
    RMS4CC  -  RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
    KIX  -  KIX (Klant index - Customer index)
    IMB  -  IMB - Intelligent Mail Barcode - Onecode - USPS-B-3200
    IMBPRE  -  IMB - Intelligent Mail Barcode - Onecode - USPS-B-3200- pre-processed
    CODABAR  -  CODABAR
    CODE11  -  CODE 11
    PHARMA  -  PHARMACODE
    PHARMA2T  -  PHARMACODE TWO-TRACKS
    DATAMATRIX  -  DATAMATRIX (ISO/IEC 16022)
    PDF417  -  PDF417 (ISO/IEC 15438:2006)
    QRCODE  -  QR-CODE
    RAW  -  2D RAW MODE comma-separated rows
    RAW2  -  2D RAW MODE rows enclosed in square parentheses

# Apache Module - URL Rewrite

The following script goes in your API_ROOT_PATH/.htaccess file

    php_value memory_limit 64M
    php_value error_reporting 0
    php_value display_errors 0
    php_value log_errors 0
    
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    
    RewriteRule ^([v0-9]{2})/(.*?)/([-?\d+]+)/([-?\d+]+)/([-?\d+]+)/(.*?)/(.*?)/(.*?).(gif|svg|png|jpg|html|unicode|binary)$ ./index.php?version=$1&data=$2&width=$3&height=$4&padding=$5&backcolour=$6&forecolour=$7&code=$8&output=$9 [L,NC,QSA]


To Turn on the module rewrite with apache run the following:

    $ sudo a2enmod rewrite
    $ sudo service apache2 restart
