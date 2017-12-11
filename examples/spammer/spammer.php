<?php

namespace Techworker\IOTA\Examples\Spammer;

use Techworker\IOTA\DI\IOTAContainer;
use Techworker\IOTA\IOTA;
use Techworker\IOTA\Node;
use Techworker\IOTA\Type\Address;
use Techworker\IOTA\Type\Seed;
use Techworker\IOTA\Type\Tag;
use Techworker\IOTA\Type\Transfer;
use Techworker\IOTA\Type\Trytes;
use Techworker\IOTA\Util\TrytesUtil;

require_once __DIR__ . '/../../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(0);

$options = [
    'keccak384-nodejs' => 'http://127.0.0.1:8081',
    'ccurlPath' => __DIR__ . '/../../ccurl'
];

$nodes = [
    new Node('http://node01.iotatoken.nl:14265'),
    new Node('http://node02.iotatoken.nl:14265'),
    new Node('http://node03.iotatoken.nl:15265'),
    new Node('http://node04.iotatoken.nl:14265'),
    new Node('http://node05.iotatoken.nl:16265')
];

$iota = new IOTA(
    new IOTAContainer($options),
    $nodes
);

$seed = '';
for($i = 0; $i <81; $i++) {
    $seed .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ9'[random_int(0, 26)];
}
$seed = new Seed('YE9FAWKVRZQDFDBTZKEWSR9QKYXOKATDQKYJRLXEEIDGWHJJ9ZI9DCJHEDXRBADGMMBHJUOPWRWXCMZGEE');
$message = 'This spam was generated by the PHP transaction spammer';
$tag = new Tag('IOTAPHP9IOTAPHPIOTA9');

function spam(IOTA $iota, $seed, $message, $tag)
{
    $node = $iota->getNode();
    echo "creating spam-transaction...\n";
    try {
        $bundleResponse = $iota->getClientApi()->sendTransfer($node, $seed, [
            (new Transfer)
                ->setRecipientAddress(new Address($seed->getSeed()))
                ->setValue(new \Techworker\IOTA\Type\Iota(0))
                ->setObsoleteTag($tag)
                ->setMessage(TrytesUtil::asciiToTrytes($message))
        ], 15, random_int(4, 12), true);

        echo "created spam-transaction:\n";
        echo "Bundle: " . (string)$bundleResponse->getBundle()->getBundleHash() . "\n";
        foreach ($bundleResponse->getBundle()->getTransactions() as $transaction) {
            echo "   Transaction: " . (string)$transaction->getTransactionHash() . "\n";
        }
        echo "Confirmed trunk:  " . (string)$bundleResponse->getTrunkTransactionHash() . "\n";
        echo "Confirmed branch: " . (string)$bundleResponse->getBranchTransactionHash() . "\n";
        echo str_repeat('-', 80) . "\n\n";
        echo "Bundle: " . (string)$bundleResponse->getBundle()->getBundleHash() . "\n";
        echo (string)$bundleResponse->getBundle()->getBundleHash() . "\n";
    }
    catch(\Exception $ex) {
        echo 'ERROR: ' . $ex->getMessage() . "\n";
    }

    sleep(3);
    spam($iota, $seed, $message, $tag);
}

spam($iota, $seed, $message, $tag);