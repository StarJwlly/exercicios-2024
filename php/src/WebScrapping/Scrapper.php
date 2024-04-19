<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  /**
   * Loads paper information from the HTML and returns the array with the data.
   */
  public function scrap(\DOMDocument $dom): array {
    $sections = $dom->getElementsByTagName('section');
    $result = [];

    $finder = new \DomXPath($dom);
    $classname = "paper-card";
    $nodes = $finder->query("//*[contains(@class, '$classname')]");

    foreach ($nodes as $node) {
      $authors = [];
      foreach ($node->firstChild->nextSibling->childNodes as $author) {
        if ($author->nodeType == 1) {
          array_push(
            $authors, new Person(
              rtrim($author->nodeValue, ';'),
              $author->attributes->getNamedItem('title')->value
            )
          );
        }
      }
      array_push(
        $result, new Paper(
          $node->lastChild->lastChild->lastChild->nodeValue,
          $node->firstChild->nodeValue,
          $node->lastChild->firstChild->nodeValue,
          $authors
        )
      );
    }

    return [$result];
  }

}
