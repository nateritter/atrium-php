<?php

try {
    $filename = sprintf(".env.testing");
    (new Dotenv\Dotenv(dirname(__DIR__), $filename))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    echo ".env for test is missing.";
    exit(1);
}
