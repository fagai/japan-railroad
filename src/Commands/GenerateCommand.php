<?php


namespace Fagai\LineData\Commands;

use Fagai\LineData\Company;
use Fagai\LineData\Line;
use Fagai\LineData\Station;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    protected static $defaultName = 'build';

    protected $comparyPath = 'company20200309.csv';
    protected $stationPath = 'station20200316free.csv';
    protected $linePath = 'line20200306free.csv';

    protected $outputPath = 'data';

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output = 'data';
        $this->outputZipCode();
        $this->outputCompany();
        $this->outputGroupStation();
        $this->outputStation();
        $this->outputLine();

        return 0;
    }

    protected function outputZipCode()
    {
        $out = '';
        exec('ken-all address KEN_ALL.csv -t json', $out);
        foreach ($out as $line) {
            $zip = json_decode($line, true);
            $outputPath = $this->outputPath . '/zip/' . $zip['zip'] . '.json';
            file_put_contents($outputPath, $line);
        }
    }

    protected function outputCompany()
    {
        if (!is_dir($this->outputPath . '/company')) {
            mkdir($this->outputPath . '/company');
        }
        foreach ($this->readCompanies() as $company) {
            $outputPath = $this->outputPath . '/company/' . $company->companyId . '.json';
            file_put_contents($outputPath, $company->getJson());
        }
    }

    protected function outputLine()
    {
        if (!is_dir($this->outputPath . '/line')) {
            mkdir($this->outputPath . '/line');
        }
        foreach ($this->readLines() as $line) {
            if (strpos($line->name, '新幹線') !== false) {
                continue;
            }

            foreach ($this->readStations() as $station) {
                if ($line->lineId === $station->lineId) {
                    $line->addStation($station);
                }
            }

            $outputPath = $this->outputPath . '/line/' . $line->lineId . '.json';
            file_put_contents($outputPath, $line->getJson());
        }
    }

    protected function outputStation()
    {
        if (!is_dir($this->outputPath . '/station')) {
            mkdir($this->outputPath . '/station');
        }

        foreach ($this->readStations() as $station) {
            $outputPath = $this->outputPath . '/station/' . $station->stationId . '.json';
            file_put_contents($outputPath, $station->getJson());
        }
    }

    protected function outputGroupStation()
    {
        $fp = fopen($this->stationPath, "r");

        $keys = fgetcsv($fp);
        $groupStations = [];
        while (($station = fgetcsv($fp)) !== false) {
            $groupStations[$station[1]][] = $station[0];
        }
        if (!is_dir($this->outputPath . '/groupStation')) {
            mkdir($this->outputPath . '/groupStation');
        }
        foreach ($groupStations as $groupId => $stations) {
            $outputPath = $this->outputPath . '/groupStation/' . $groupId . '.json';
            file_put_contents($outputPath, json_encode(['stationGroupId' => $groupId, 'stations' => $stations]));
        }
    }

    /**
     * @return \Generator|Company[]
     */
    protected function readCompanies()
    {
        $fp = fopen($this->comparyPath, "r");

        $keys = fgetcsv($fp);

        while (($company = fgetcsv($fp)) !== false) {
            yield new Company(...$company);
        }
        fclose($fp);
    }

    /**
     * @return \Generator|Station[]
     */
    protected function readStations()
    {
        $fp = fopen($this->stationPath, "r");

        $keys = fgetcsv($fp);

        while (($station = fgetcsv($fp)) !== false) {
            $zipData = $this->getZipData($station[7]);
            $station = array_merge($station, [$zipData['pref'], $zipData['city'], $zipData['town']]);
            yield new Station(...$station);
        }
        fclose($fp);
    }

    /**
     * @return \Generator|Line[]
     */
    protected function readLines()
    {
        $fp = fopen($this->linePath, "r");

        $keys = fgetcsv($fp);

        while (($line = fgetcsv($fp)) !== false) {
            yield new Line(...$line);
        }
        fclose($fp);
    }

    protected function getZipData($zipCode)
    {
        return json_decode(file_get_contents('data/zip/' . str_replace('-', '', $zipCode) . '.json'), true);
    }
}
