<?php
require 'vendor/autoload.php'; // Include the Guzzle library
use GuzzleHttp\Client;
$client = new Client();
$url = 'https://satta-king-fast.com';

try {
    // Send an HTTP GET request to the webpage
    $response = $client->request('GET', $url);

    // Check if the request was successful (status code 200)
    if ($response->getStatusCode() == 200) {
        $html = $response->getBody()->getContents();

        // Create a DOMDocument to parse the HTML
        $doc = new DOMDocument();
        @$doc->loadHTML($html); // Suppress warnings for badly formed HTML

        // Create a DOMXPath to query the DOMDocument
        $xpath = new DOMXPath($doc);

        // Define the class name of the elements you want to scrape
        $className = 'game-name';

        // Query for elements with the specified class name
        $elements = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $className ')]");

        $data = [];

        // Loop through the found elements
        foreach ($elements as $element) {
            // You can extract specific data from the elements here
            // For example, to get the element's text content:
            $data[] = $element->textContent;
        }

        // Encode the data as JSON
        $json = json_encode($data);

        // Output the JSON data
        echo $json;
    } else {
        echo "Failed to retrieve the webpage. Status code: " . $response->getStatusCode();
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}