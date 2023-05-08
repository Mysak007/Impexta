<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Command;

use App\Eshop\Enum\Country;
use Impexta\Product\Infrastructure\XMLFeedGenerator\Factory\XmlFeedModelFactory;
use Impexta\Product\Infrastructure\XMLFeedGenerator\HeurekaXmlFeedGenerator;
use Impexta\Product\Infrastructure\XMLFeedGenerator\SaveGeneratedFeedService;
use Impexta\Product\Infrastructure\XMLFeedGenerator\XmlFeedGeneratorInterface;
use Impexta\Product\Infrastructure\XMLFeedGenerator\ZboziXmlFeedGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class XmlFeedGeneratorCommand extends Command
{
    public static $defaultName = 'impexta:generate-xml-feed';
    private XmlFeedModelFactory $xmlFeedModelFactory;
    private SaveGeneratedFeedService $saveGeneratedFeedService;

    /** @var array <string,XmlFeedGeneratorInterface> $xmlFeedGenerators */
    private array $xmlFeedGenerators = [];

    public function __construct(
        XmlFeedModelFactory $xmlFeedModelFactory,
        HeurekaXmlFeedGenerator $heurekaXmlFeedGenerator,
        ZboziXmlFeedGenerator $zboziXmlFeedGenerator,
        SaveGeneratedFeedService $saveGeneratedFeedService
    ) {
        $this->xmlFeedModelFactory = $xmlFeedModelFactory;
        $this->xmlFeedGenerators[HeurekaXmlFeedGenerator::name()] = $heurekaXmlFeedGenerator;
        $this->xmlFeedGenerators[ZboziXmlFeedGenerator::name()] = $zboziXmlFeedGenerator;
        $this->saveGeneratedFeedService = $saveGeneratedFeedService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'provider',
                InputArgument::REQUIRED,
                'Specify provider. Available providers: ' . implode(
                    ', ',
                    array_keys($this->xmlFeedGenerators)
                )
            );
    }

    /** @SuppressWarnings("PHPMD.UnusedFormalParameter") */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $provider */
        $provider = $input->getArgument('provider');
        $feedModel = $this->xmlFeedModelFactory->mapXMLFeedModel();

        foreach (Country::values() as $country) {
            $generatedXML = $this->xmlFeedGenerators[$provider]->generate($feedModel, Country::get($country));
            $this->saveGeneratedFeedService->save(
                $provider,
                Country::getCurrency(Country::get($country)),
                $generatedXML
            );
        }

        return Command::SUCCESS;
    }
}
