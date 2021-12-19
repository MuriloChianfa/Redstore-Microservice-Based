<?php

declare(strict_types=1);

namespace Source\Domain\Templates;

abstract class ConfirmEmail
{
    public final static function bind(string $confirmURL = ''): string
    {
        if (empty($confirmURL)) {
            throw new \InvalidArgumentException('Please provide the confirmation URL');
        }

        return '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                Please confirm your email ' . $confirmURL . '
            </body>
            </html>
        ';
    } 
}
