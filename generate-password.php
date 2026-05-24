<?php
/**
 * Password Hash Generator
 *
 * Usage:
 *   php generate-password.php                    # Interactive (prompt for password)
 *   php generate-password.php mypassword          # Hash a specific password
 *   php generate-password.php --rounds 15         # Interactive with custom rounds
 *   php generate-password.php mypassword --rounds 15
 */

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Parse args
$password = null;
$rounds = (int) (env('BCRYPT_ROUNDS', 12));

foreach ($argv as $i => $arg) {
    if ($i === 0) continue;
    if ($arg === '--rounds' && isset($argv[$i + 1])) {
        $rounds = (int) $argv[$i + 1];
    } elseif (!str_starts_with($arg, '--') && $password === null) {
        $password = $arg;
    }
}

// Interactive if no password given
if ($password === null) {
    echo "Enter password: ";
    $password = trim(fgets(STDIN));
    if ($password === '') {
        echo "Error: password cannot be empty.\n";
        exit(1);
    }
    echo "Rounds [$rounds]: ";
    $input = trim(fgets(STDIN));
    if ($input !== '' && is_numeric($input)) {
        $rounds = (int) $input;
    }
}

$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => $rounds]);

echo str_repeat('-', 60) . "\n";
echo "Algorithm : bcrypt\n";
echo "Rounds    : $rounds\n";
echo "Password  : $password\n";
echo "Hash      : $hash\n";
echo str_repeat('-', 60) . "\n";
echo "Verification: " . (password_verify($password, $hash) ? 'PASS' : 'FAIL') . "\n";
echo str_repeat('-', 60) . "\n";
