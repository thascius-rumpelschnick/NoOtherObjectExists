<?php

/* Added through input filter in form class: */

'validators' => [ 
    [
        'name' => NoOtherObjectExists::class,
        'options' => [
            'object_repository' => $this->em->getRepository(PATH/TO/YOUR/CLASS),
            'fields' => 'name',
            'messages' => [
                'objectFound' => 'Website already exists!',
            ],
            'property' => [
                'name' => 'id',                   // any property you want to check against
                'value' => $this->id,             // value of said property is handed over in the form constructor
            ],
        ],
    ],
]
