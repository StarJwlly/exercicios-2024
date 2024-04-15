<?php

namespace Chuva\Php\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

/**
 * Runner for the Webscrapping exercice.
 */
class Main {

  /**
   * Main runner, instantiates a Scrapper and runs.
   */
  public static function run(): void {
    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

    $data = (new Scrapper())->scrap($dom);

    // Write your logic to save the output file below.
    $writer = WriterEntityFactory::createXLSXWriter();
    $writer->openToFile(__DIR__ .'/../../assets/result.xlsx'); 

    $header = ['ID', 'Title', 'Type', 'Author 1', 'Institution 1', 'Author 2', 'Institution 2', 'Author 3', 'Institution 3', 'Author 4', 'Institution 4', 'Author 5', 'Institution 5', 'Author 6', 'Institution 6', 'Author 7', 'Institution 7', 'Author 8', 'Institution 8', 'Author 9', 'Institution 9', 'Author 10', 'Institution 10', 'Author 11', 'Institution 11', 'Author 12', 'Institution 12', 'Author 13', 'Institution 13', 'Author 14', 'Institution 14', 'Author 15', 'Institution 15', 'Author 16', 'Institution 16'];
    $writer->addRow(WriterEntityFactory::createRowFromArray($header));

    foreach($data[0] as $d){
      $row = [$d->id, $d->title, $d->type];
      foreach($d->authors as $a){
        array_push($row, $a->name);
        array_push($row, $a->institution);
      }
      $writer->addRow(WriterEntityFactory::createRowFromArray($row));
    }

    $writer->close();
    print_r($data);
  }

}
