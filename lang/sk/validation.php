<?php

declare(strict_types=1);

return [
    'accepted'             => ':Attribute musí byť akceptovaný.',
    'accepted_if'          => ':Attribute musí byť akceptovaný, ak :other je :value.',
    'active_url'           => ':Attribute má neplatnú URL adresu.',
    'after'                => ':Attribute musí byť dátum po :date.',
    'after_or_equal'       => ':Attribute musí byť dátum po alebo presne :date.',
    'alpha'                => ':Attribute môže obsahovať len písmená.',
    'alpha_dash'           => ':Attribute musí obsahovať len písmená, čísla, pomlčky a podčiarknutia.',
    'alpha_num'            => ':Attribute musí obsahovať len písmená a číslice.',
    'array'                => ':Attribute musí byť pole.',
    'ascii'                => 'Číslo :attribute musí obsahovať iba alfanumerické znaky a symboly bez interpunkcie.',
    'before'               => ':Attribute musí byť dátum pred :date.',
    'before_or_equal'      => ':Attribute musí byť dátum pred alebo presne :date.',
    'between'              => [
        'array'   => ':Attribute musí mať rozsah :min - :max.',
        'file'    => ':Attribute musí mať veľkosť medzi :min - :max kB.',
        'numeric' => ':Attribute musí mať hodnotu medzi :min - :max.',
        'string'  => ':Attribute musí mať dĺžku medzi :min - :max znakov.',
    ],
    'boolean'              => ':Attribute musí mať hodnotu true alebo false.',
    'can'                  => 'Pole :attribute obsahuje neoprávnenú hodnotu.',
    'confirmed'            => 'Musíte potvrdiť :attribute.',
    'contains'             => 'V poli :attribute chýba požadovaná hodnota.',
    'current_password'     => 'Heslo je nesprávne.',
    'date'                 => ':Attribute má neplatný dátum.',
    'date_equals'          => ':Attribute musí byť dátum rovnajúci sa :date.',
    'date_format'          => ':Attribute sa nezhoduje s formátom :format.',
    'decimal'              => ':Attribute musí mať :decimal desatinných miest.',
    'declined'             => ':Attribute musí byť zamietnutý.',
    'declined_if'          => ':Attribute musí byť zamietnutý, ak :other je :value.',
    'different'            => ':Attribute a :other musia byť odlišné.',
    'digits'               => ':Attribute musí mať :digits číslic.',
    'digits_between'       => ':Attribute musí mať rozsah :min až :max číslic.',
    'dimensions'           => ':Attribute má neplatné rozmery obrázka.',
    'distinct'             => ':Attribute má duplicitnú hodnotu.',
    'doesnt_end_with'      => ':Attribute nesmie končiť jednou z týchto možností: :values.',
    'doesnt_start_with'    => ':Attribute nesmie začínať jednou z týchto možností: :values.',
    'email'                => ':Attribute musí byť platná emailová adresa.',
    'ends_with'            => ':Attribute musí končiť jednou z týchto možností: :values.',
    'enum'                 => 'Vybraná hodnota :attribute je neplatná.',
    'exists'               => 'Zvolená Hodnota :attribute neexistuje.',
    'extensions'           => 'Pole :attribute musí mať jednu z nasledujúcich možností: :values.',
    'file'                 => ':Attribute musí byť súbor.',
    'filled'               => 'Pole :attribute musí mať hodnotu.',
    'gt'                   => [
        'array'   => ':Attribute musí mať viac prvkov ako :value.',
        'file'    => ':Attribute musí mať viac kB ako :value.',
        'numeric' => 'Hodnota :attribute musí byť väčšia ako :value.',
        'string'  => ':Attribute musí mať viac znakov ako :value.',
    ],
    'gte'                  => [
        'array'   => ':Attribute musí mať rovnaký alebo väčší počet prvkov ako :value.',
        'file'    => ':Attribute musí mať rovnaký alebo väčší počet kB ako :value.',
        'numeric' => 'Hodnota :attribute musí byť väčšia alebo rovná ako :value.',
        'string'  => ':Attribute musí mať rovnaký alebo väčší počet znakov ako :value.',
    ],
    'hex_color'            => 'Pole :attribute musí mať farbu vo formáte HEX.',
    'image'                => ':Attribute musí byť obrázok.',
    'in'                   => 'Hodnota :attribute nieje v zozname povolených hodnôt.',
    'in_array'             => ':Attribute sa nenachádza v :other.',
    'integer'              => ':Attribute musí byť celé číslo.',
    'ip'                   => ':Attribute musí byť platná IP adresa.',
    'ipv4'                 => ':Attribute musí byť platná IPv4 adresa.',
    'ipv6'                 => ':Attribute musí byť platná IPv6 adresa.',
    'json'                 => ':Attribute musí byť platný JSON reťazec.',
    'list'                 => 'Pole :attribute musí byť zoznam.',
    'lowercase'            => ':Attribute musí byť napísaný malými znakmi.',
    'lt'                   => [
        'array'   => ':Attribute musí mať menej položiek ako :value.',
        'file'    => ':Attribute musí mať menej kB ako :value.',
        'numeric' => 'Hodnota :attribute musí byť menšia ako :value.',
        'string'  => ':Attribute musí mať menej znakov ako :value.',
    ],
    'lte'                  => [
        'array'   => ':Attribute musí mať rovnaký alebo menší počet položiek ako :value.',
        'file'    => ':Attribute musí mať rovnaký alebo menší počet kB ako :value.',
        'numeric' => 'Hodnota :attribute musí byť menšia alebo rovná ako :value.',
        'string'  => ':Attribute musí mať rovnaký alebo menší počet znakov ako :value.',
    ],
    'mac_address'          => ':Attribute musí byť platná MAC adresa.',
    'max'                  => [
        'array'   => ':Attribute nemôže mať viac ako :max položiek.',
        'file'    => ':Attribute nesmie mať viac ako :max kB.',
        'numeric' => ':Attribute nesmie mať viac ako :max.',
        'string'  => ':Attribute nesmie mať viac ako :max znakov.',
    ],
    'max_digits'           => ':Attribute nesmie mať viac ako :max číslic.',
    'mimes'                => ':Attribute musí byť súbor s koncovkou: :values.',
    'mimetypes'            => ':Attribute musí byť súbor s koncovkou: :values.',
    'min'                  => [
        'array'   => ':Attribute musí mať minimálne :min položiek.',
        'file'    => ':Attribute musí mať minimálne :min kB.',
        'numeric' => ':Attribute musí byť minimálne :min.',
        'string'  => ':Attribute musí mať minimálne :min znakov.',
    ],
    'min_digits'           => ':Attribute musí mať minimálne :min číslic.',
    'missing'              => 'Pole :attribute musí chýbať.',
    'missing_if'           => 'Pole :attribute musí chýbať, ak :other je :value.',
    'missing_unless'       => 'Pole :attribute musí chýbať, pokiaľ :other nie je :value.',
    'missing_with'         => 'Pole :attribute musí chýbať, ak existuje :values.',
    'missing_with_all'     => 'Pole :attribute musí chýbať, ak existuje :values.',
    'multiple_of'          => ':Attribute musí byť násobkom :value',
    'not_in'               => 'Zvolená hodnota :attribute je neplatná.',
    'not_regex'            => ':Attribute má neplatný formát.',
    'numeric'              => ':Attribute musí byť číslo.',
    'password'             => [
        'letters'       => ':Attribute musí obsahovať aspoň jedno písmeno.',
        'mixed'         => ':Attribute musí obsahovať aspoň jedno veľké a jedno malé písmeno.',
        'numbers'       => ':Attribute musí obsahovať aspoň jedno číslo.',
        'symbols'       => ':Attribute musí obsahovať aspoň jeden symbol.',
        'uncompromised' => 'Hodnota :attribute sa objavila pri úniku údajov. Vyberte iný :attribute.',
    ],
    'present'              => ':Attribute musí byť odoslaný.',
    'present_if'           => 'Pole :attribute musí byť odoslané, ak :other je :value.',
    'present_unless'       => 'Pole :attribute musí byť odoslané, pokiaľ :other nie je :value.',
    'present_with'         => 'Pole :attribute musí byť odoslané, ak existuje :values.',
    'present_with_all'     => 'Pole :attribute musí byť odoslané, ak existuje :values.',
    'prohibited'           => 'Pole :attribute je zakázané.',
    'prohibited_if'        => 'Pole :attribute je zakázané, keď :other je :value.',
    'prohibited_unless'    => 'Pole :attribute je zakázané, pokiaľ :other nie je v :values.',
    'prohibits'            => 'Pole :attribute je zakazáané, keď je :other povolené.',
    'regex'                => ':Attribute má neplatný formát.',
    'required'             => 'Pole :attribute je povinné.',
    'required_array_keys'  => 'Pole :attribute musí obsahovať položky: :values.',
    'required_if'          => 'Pole :attribute je povinné keď :other je :value.',
    'required_if_accepted' => 'Pole :attribute je povinné, keď je :other povolené.',
    'required_if_declined' => 'Pole :attribute je povinné, keď je :other zamietnuté.',
    'required_unless'      => 'Pole :attribute je povinné, pokiaľ :other nemá hodnotu :values.',
    'required_with'        => 'Pole :attribute je povinné, keď je nastavené :values.',
    'required_with_all'    => 'Pole :attribute je povinné, ak je nastavené :values.',
    'required_without'     => 'Pole :attribute je povinné, keď nie je nastavené :values.',
    'required_without_all' => 'Pole :attribute je povinné, ak nie je nastavené :values.',
    'same'                 => 'Hodnota :attribute sa musí zhodovať s hodnotou z :other.',
    'size'                 => [
        'array'   => ':Attribute musí obsahovať :size položky.',
        'file'    => ':Attribute musí mať :size kB.',
        'numeric' => ':Attribute musí byť :size.',
        'string'  => ':Attribute musí mať :size znakov.',
    ],
    'starts_with'          => ':Attribute musí začínať niektorou z hodnôt: :values',
    'string'               => ':Attribute musí byť reťazec znakov.',
    'timezone'             => ':Attribute musí byť platné časové pásmo.',
    'ulid'                 => ':Attribute musí byť platné ULID.',
    'unique'               => ':Attribute už existuje.',
    'uploaded'             => 'Nepodarilo sa nahrať :attribute.',
    'uppercase'            => ':Attribute musí obsahovať veľké znaky.',
    'url'                  => ':Attribute musí mať formát URL.',
    'uuid'                 => ':Attribute musí byť platné UUID.',
    'attributes'           => [
        'address'                  => 'adresa',
        'affiliate_url'            => 'affiliate URL',
        'age'                      => 'vek',
        'amount'                   => 'množstvo',
        'announcement'             => 'oznámenie',
        'area'                     => 'oblasť',
        'audience_prize'           => 'divácka cena',
        'audience_winner'          => 'audience winner',
        'available'                => 'dostupne',
        'birthday'                 => 'deň narodenia',
        'body'                     => 'správa',
        'city'                     => 'mesto',
        'company'                  => 'company',
        'compilation'              => 'kompilácia',
        'concept'                  => 'koncepcie',
        'conditions'               => 'podmienky',
        'content'                  => 'obsah',
        'contest'                  => 'contest',
        'country'                  => 'krajina',
        'cover'                    => 'kryt',
        'created_at'               => 'vytvorené o',
        'creator'                  => 'tvorca',
        'currency'                 => 'mena',
        'current_password'         => 'aktuálne heslo',
        'customer'                 => 'zákazníka',
        'date'                     => 'dátum',
        'date_of_birth'            => 'dátum narodenia',
        'dates'                    => 'termíny',
        'day'                      => 'deň',
        'deleted_at'               => 'vymazané o',
        'description'              => 'popis',
        'display_type'             => 'typ zobrazenia',
        'district'                 => 'okres',
        'duration'                 => 'trvanie',
        'email'                    => 'e-mailová adresa',
        'excerpt'                  => 'úryvok',
        'filter'                   => 'filter',
        'finished_at'              => 'skončil o',
        'first_name'               => 'krstné meno',
        'gender'                   => 'pohlavie',
        'grand_prize'              => 'veľká cena',
        'group'                    => 'skupina',
        'hour'                     => 'hodina',
        'image'                    => 'obraz',
        'image_desktop'            => 'obrázok pracovnej plochy',
        'image_main'               => 'hlavný obrázok',
        'image_mobile'             => 'mobilný obrázok',
        'images'                   => 'snímky',
        'is_audience_winner'       => 'je víťazom publika',
        'is_hidden'                => 'je skrytý',
        'is_subscribed'            => 'je prihlásený',
        'is_visible'               => 'je viditeľný',
        'is_winner'                => 'je víťaz',
        'items'                    => 'položky',
        'key'                      => 'kľúč',
        'last_name'                => 'priezvisko',
        'lesson'                   => 'lekcia',
        'line_address_1'           => 'adresný riadok 1',
        'line_address_2'           => 'adresný riadok 2',
        'login'                    => 'Prihlásiť sa',
        'message'                  => 'správa',
        'middle_name'              => 'druhé meno',
        'minute'                   => 'minúta',
        'mobile'                   => 'telefón',
        'month'                    => 'mesiac',
        'name'                     => 'meno',
        'national_code'            => 'národný kód',
        'number'                   => 'číslo',
        'password'                 => 'heslo',
        'password_confirmation'    => 'heslo znovu',
        'phone'                    => 'telefón',
        'photo'                    => 'fotografia',
        'portfolio'                => 'portfólio',
        'postal_code'              => 'poštové smerovacie číslo',
        'preview'                  => 'Náhľad',
        'price'                    => 'cena',
        'product_id'               => 'identifikačné číslo produktu',
        'product_uid'              => 'UID produktu',
        'product_uuid'             => 'UUID produktu',
        'promo_code'               => 'propagačný kód',
        'state'                 => 'provincia',
        'quantity'                 => 'množstvo',
        'reason'                   => 'dôvod',
        'recaptcha_response_field' => 'pole odpovede recaptcha',
        'referee'                  => 'rozhodcu',
        'referees'                 => 'rozhodcov',
        'reject_reason'            => 'odmietnuť rozum',
        'remember'                 => 'zapamätať si',
        'restored_at'              => 'obnovené o',
        'result_text_under_image'  => 'text výsledku pod obrázkom',
        'role'                     => 'rola',
        'rule'                     => 'pravidlo',
        'rules'                    => 'pravidlá',
        'second'                   => 'sekunda',
        'sex'                      => 'pohlavie',
        'shipment'                 => 'náklad',
        'short_text'               => 'kratký text',
        'size'                     => 'rozmer',
        'skills'                   => 'zručnosti',
        'slug'                     => 'slimák',
        'specialization'           => 'špecializácia',
        'started_at'               => 'začalo o',
        'state'                    => 'štát',
        'status'                   => 'postavenie',
        'street'                   => 'ulica',
        'student'                  => 'študent',
        'subject'                  => 'predmet',
        'tag'                      => 'tag',
        'tags'                     => 'značky',
        'teacher'                  => 'učiteľ',
        'terms'                    => 'podmienky',
        'test_description'         => 'testový popis',
        'test_locale'              => 'testová lokalizácia',
        'test_name'                => 'testové meno',
        'text'                     => 'text',
        'time'                     => 'čas',
        'title'                    => 'názov',
        'type'                     => 'typu',
        'updated_at'               => 'aktualizované o',
        'user'                     => 'užívateľ',
        'username'                 => 'používateľské meno',
        'value'                    => 'hodnotu',
        'winner'                   => 'winner',
        'work'                     => 'work',
        'year'                     => 'rok',
    ],
];
