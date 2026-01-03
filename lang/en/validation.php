<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Valideerimise keelestringid
    |--------------------------------------------------------------------------
    |
    | Neid teateid kasutab Laraveli valideerija.
    | Võid neid vastavalt oma rakenduse vajadustele kohandada.
    |
    */

    'accepted' => ':attribute tuleb kinnitada.',
    'accepted_if' => ':attribute tuleb kinnitada, kui :other on :value.',
    'active_url' => ':attribute peab olema kehtiv URL.',
    'after' => ':attribute peab olema kuupäev pärast :date.',
    'after_or_equal' => ':attribute peab olema kuupäev, mis on pärast või võrdne kuupäevaga :date.',
    'alpha' => ':attribute võib sisaldada ainult tähti.',
    'alpha_dash' => ':attribute võib sisaldada ainult tähti, numbreid, sidekriipse ja alakriipse.',
    'alpha_num' => ':attribute võib sisaldada ainult tähti ja numbreid.',
    'any_of' => ':attribute on vigane.',
    'array' => ':attribute peab olema massiiv.',
    'ascii' => ':attribute võib sisaldada ainult ASCII tähemärke.',
    'before' => ':attribute peab olema kuupäev enne :date.',
    'before_or_equal' => ':attribute peab olema kuupäev, mis on enne või võrdne kuupäevaga :date.',

    'between' => [
        'array' => ':attribute peab sisaldama vahemikus :min kuni :max elementi.',
        'file' => ':attribute peab olema vahemikus :min kuni :max kilobaiti.',
        'numeric' => ':attribute peab olema vahemikus :min kuni :max.',
        'string' => ':attribute peab olema vahemikus :min kuni :max tähemärki.',
    ],

    'boolean' => ':attribute peab olema tõene või väär.',
    'can' => ':attribute sisaldab lubamatut väärtust.',
    'confirmed' => ':attribute kinnitus ei ühti.',
    'contains' => ':attribute ei sisalda nõutud väärtust.',
    'current_password' => 'Salasõna on vale.',
    'date' => ':attribute peab olema kehtiv kuupäev.',
    'date_equals' => ':attribute peab olema kuupäev, mis on võrdne kuupäevaga :date.',
    'date_format' => ':attribute peab vastama formaadile :format.',
    'decimal' => ':attribute peab sisaldama :decimal kümnendkohta.',
    'declined' => ':attribute tuleb tagasi lükata.',
    'declined_if' => ':attribute tuleb tagasi lükata, kui :other on :value.',
    'different' => ':attribute ja :other peavad olema erinevad.',
    'digits' => ':attribute peab olema :digits numbrit pikk.',
    'digits_between' => ':attribute peab olema vahemikus :min kuni :max numbrit.',
    'dimensions' => ':attribute pildi mõõtmed on valed.',
    'distinct' => ':attribute sisaldab duplikaatväärtust.',
    'doesnt_contain' => ':attribute ei tohi sisaldada järgmisi väärtusi: :values.',
    'doesnt_end_with' => ':attribute ei tohi lõppeda ühega järgmistest: :values.',
    'doesnt_start_with' => ':attribute ei tohi alata ühega järgmistest: :values.',
    'email' => ':attribute peab olema kehtiv e-posti aadress.',
    'encoding' => ':attribute peab olema kodeeritud vormingus :encoding.',
    'ends_with' => ':attribute peab lõppema ühega järgmistest: :values.',
    'enum' => 'Valitud :attribute on vigane.',
    'exists' => 'Valitud :attribute on vigane.',
    'extensions' => ':attribute peab olema ühega järgmistest faililaienditest: :values.',
    'file' => ':attribute peab olema fail.',
    'filled' => ':attribute peab olema täidetud.',

    'gt' => [
        'array' => ':attribute peab sisaldama rohkem kui :value elementi.',
        'file' => ':attribute peab olema suurem kui :value kilobaiti.',
        'numeric' => ':attribute peab olema suurem kui :value.',
        'string' => ':attribute peab olema pikem kui :value tähemärki.',
    ],

    'gte' => [
        'array' => ':attribute peab sisaldama vähemalt :value elementi.',
        'file' => ':attribute peab olema vähemalt :value kilobaiti.',
        'numeric' => ':attribute peab olema vähemalt :value.',
        'string' => ':attribute peab olema vähemalt :value tähemärki.',
    ],

    'hex_color' => ':attribute peab olema kehtiv heksavärv.',
    'image' => ':attribute peab olema pilt.',
    'in' => 'Valitud :attribute on vigane.',
    'in_array' => ':attribute peab eksisteerima väljas :other.',
    'in_array_keys' => ':attribute peab sisaldama vähemalt ühte järgmistest võtmetest: :values.',
    'integer' => ':attribute peab olema täisarv.',
    'ip' => ':attribute peab olema kehtiv IP-aadress.',
    'ipv4' => ':attribute peab olema kehtiv IPv4 aadress.',
    'ipv6' => ':attribute peab olema kehtiv IPv6 aadress.',
    'json' => ':attribute peab olema kehtiv JSON-string.',
    'list' => ':attribute peab olema nimekiri.',
    'lowercase' => ':attribute peab olema väiketähtedega.',

    'lt' => [
        'array' => ':attribute peab sisaldama vähem kui :value elementi.',
        'file' => ':attribute peab olema väiksem kui :value kilobaiti.',
        'numeric' => ':attribute peab olema väiksem kui :value.',
        'string' => ':attribute peab olema lühem kui :value tähemärki.',
    ],

    'lte' => [
        'array' => ':attribute ei tohi sisaldada rohkem kui :value elementi.',
        'file' => ':attribute peab olema väiksem või võrdne :value kilobaidiga.',
        'numeric' => ':attribute peab olema väiksem või võrdne :value.',
        'string' => ':attribute peab olema lühem või võrdne :value tähemärgiga.',
    ],

    'mac_address' => ':attribute peab olema kehtiv MAC-aadress.',
    'max' => [
        'array' => ':attribute ei tohi sisaldada rohkem kui :max elementi.',
        'file' => ':attribute ei tohi olla suurem kui :max kilobaiti.',
        'numeric' => ':attribute ei tohi olla suurem kui :max.',
        'string' => ':attribute ei tohi olla pikem kui :max tähemärki.',
    ],

    'max_digits' => ':attribute ei tohi olla rohkem kui :max numbrit.',
    'mimes' => ':attribute peab olema fail tüübiga: :values.',
    'mimetypes' => ':attribute peab olema fail tüübiga: :values.',

    'min' => [
        'array' => ':attribute peab sisaldama vähemalt :min elementi.',
        'file' => ':attribute peab olema vähemalt :min kilobaiti.',
        'numeric' => ':attribute peab olema vähemalt :min.',
        'string' => ':attribute peab olema vähemalt :min tähemärki.',
    ],

    'min_digits' => ':attribute peab olema vähemalt :min numbrit.',
    'missing' => ':attribute peab puuduma.',
    'missing_if' => ':attribute peab puuduma, kui :other on :value.',
    'missing_unless' => ':attribute peab puuduma, kui :other ei ole :value.',
    'missing_with' => ':attribute peab puuduma, kui :values on olemas.',
    'missing_with_all' => ':attribute peab puuduma, kui kõik :values on olemas.',
    'multiple_of' => ':attribute peab olema :value kordne.',
    'not_in' => 'Valitud :attribute on vigane.',
    'not_regex' => ':attribute formaat on vigane.',
    'numeric' => ':attribute peab olema number.',

    'password' => [
        'letters' => ':attribute peab sisaldama vähemalt ühte tähte.',
        'mixed' => ':attribute peab sisaldama vähemalt ühte suurtähte ja ühte väiketähte.',
        'numbers' => ':attribute peab sisaldama vähemalt ühte numbrit.',
        'symbols' => ':attribute peab sisaldama vähemalt ühte sümbolit.',
        'uncompromised' => 'See :attribute on lekkinud andmebaasis. Palun vali uus salasõna.',
    ],

    'present' => ':attribute peab olema olemas.',
    'present_if' => ':attribute peab olema olemas, kui :other on :value.',
    'present_unless' => ':attribute peab olema olemas, kui :other ei ole :value.',
    'present_with' => ':attribute peab olema olemas, kui :values on olemas.',
    'present_with_all' => ':attribute peab olema olemas, kui kõik :values on olemas.',
    'prohibited' => ':attribute on keelatud.',
    'prohibited_if' => ':attribute on keelatud, kui :other on :value.',
    'prohibited_if_accepted' => ':attribute on keelatud, kui :other on kinnitatud.',
    'prohibited_if_declined' => ':attribute on keelatud, kui :other on tagasi lükatud.',
    'prohibited_unless' => ':attribute on keelatud, kui :other ei ole väärtustes :values.',
    'prohibits' => ':attribute keelab välja :other.',
    'regex' => ':attribute formaat on vigane.',
    'required' => ':attribute on kohustuslik.',
    'required_array_keys' => ':attribute peab sisaldama võtmeid: :values.',
    'required_if' => ':attribute on kohustuslik, kui :other on :value.',
    'required_if_accepted' => ':attribute on kohustuslik, kui :other on kinnitatud.',
    'required_if_declined' => ':attribute on kohustuslik, kui :other on tagasi lükatud.',
    'required_unless' => ':attribute on kohustuslik, kui :other ei ole väärtustes :values.',
    'required_with' => ':attribute on kohustuslik, kui :values on olemas.',
    'required_with_all' => ':attribute on kohustuslik, kui kõik :values on olemas.',
    'required_without' => ':attribute on kohustuslik, kui :values ei ole olemas.',
    'required_without_all' => ':attribute on kohustuslik, kui ükski :values ei ole olemas.',
    'same' => ':attribute peab ühtima väljaga :other.',

    'size' => [
        'array' => ':attribute peab sisaldama :size elementi.',
        'file' => ':attribute peab olema :size kilobaiti.',
        'numeric' => ':attribute peab olema :size.',
        'string' => ':attribute peab olema :size tähemärki.',
    ],

    'starts_with' => ':attribute peab algama ühega järgmistest: :values.',
    'string' => ':attribute peab olema tekst.',
    'timezone' => ':attribute peab olema kehtiv ajavöönd.',
    'unique' => ':attribute on juba kasutusel.',
    'uploaded' => ':attribute üleslaadimine ebaõnnestus.',
    'uppercase' => ':attribute peab olema suurtähtedega.',
    'url' => ':attribute peab olema kehtiv URL.',
    'ulid' => ':attribute peab olema kehtiv ULID.',
    'uuid' => ':attribute peab olema kehtiv UUID.',

    /*
    |--------------------------------------------------------------------------
    | Kohandatud valideerimisteated
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'kohandatud-teade',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atribuutide nimed
    |--------------------------------------------------------------------------
    |
    | Siin saad asendada näiteks "email" → "E-posti aadress"
    |
    */

    'attributes' => [],

];
