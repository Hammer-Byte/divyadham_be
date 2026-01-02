<?php

return [

    'APP_NAME' => env('APP_NAME'),

    'system_admin_and_user_id' => 1,
    
    'committee_members_role' => [
                                'president' => 'President',
                                'secretary' => 'Secretary',
                                'treasurer' => 'Treasurer',
                                'member' => 'Member'
                            ],

    'post_types' => [
                        'text' => 'Text',
                        'link' => 'Link',
                        'media' => 'Media',
                        'donation' => 'Donation'
                    ],
];
