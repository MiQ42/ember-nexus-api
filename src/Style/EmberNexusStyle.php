<?php

declare(strict_types=1);

namespace App\Style;

use App\Console\EmberNexusOutputWrapper;
use Exception;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Terminal;

use function Safe\preg_replace;

class EmberNexusStyle extends SymfonyStyle
{
    private int $lineLength = 120;
    private bool $isInSection = false;

    public function __construct(
        private InputInterface $input, /** @phpstan-ignore-line */
        private OutputInterface $output,
    ) {
        if ($output instanceof ConsoleOutput) {
            $terminal = new Terminal();
            $this->lineLength = $terminal->getWidth();
        }
        $output->getFormatter()->setStyle(
            'ember-nexus',
            new OutputFormatterStyle('#ffffff', '#D82739')
        );
        $output->getFormatter()->setStyle(
            'ember-nexus-purple',
            new OutputFormatterStyle('#2C1D32', '#D82739')
        );
        $output->getFormatter()->setStyle(
            'ember-nexus-orange',
            new OutputFormatterStyle('#FA9640', '#D82739')
        );
        parent::__construct($input, $output);
    }

    public function title(string $message): void
    {
        $versionString = 'development version';
        $appMode = 'production';
        if ('prod' !== getenv('APP_ENV')) {
            $appMode = 'development';
        }
        $envVersion = getenv('VERSION');
        if (is_string($envVersion)) {
            if ($envVersion) {
                $version = preg_replace('/[^0-9.]/', '', $envVersion);
                // @phpstan-ignore-next-line
                if (is_array($version)) {
                    $version = implode('', $version);
                }
                $versionString = 'v'.$version;
            }
        }
        $this->newLine();
        $this->writeln(sprintf(
            "    <fg=gray>▄</>   \n".
            "  <fg=gray>▄<fg=gray;bg=bright-red>▀ ▀</>▄</>  <options=bold>Ember Nexus API</>\n".
            "   <fg=bright-red>▀<fg=bright-white>█</>▀</>   %s, %s mode\n".
            "\n".
            "  <options=bold>%s</>\n",
            $versionString,
            $appMode,
            $message
        ));
    }

    /** @phpstan-ignore-next-line */
    public function finalMessage(array|string $message): void
    {
        if ($this->isInSection) {
            throw new Exception('Function success() should only be called at end of command, not within sections.');
        }
        if (is_string($message)) {
            $message = [$message];
        }
        $prefix = '▶ ';
        foreach ($message as $line) {
            $this->writeln($prefix.$line);
            $prefix = '  ';
        }
        $this->newLine();
    }

    public function startSection(string $message): void
    {
        $this->writeln(sprintf(
            '┌<options=bold> %s </>%s',
            $message,
            str_repeat('─', max(0, $this->lineLength - strlen($message) - 3))
        ));
        $this->isInSection = true;
    }

    public function stopSection(string $message): void
    {
        $this->isInSection = false;
        $this->writeln('└ '.$message);
        $this->newLine();
    }

    /**
     * @param iterable<mixed, mixed>|string $messages
     *
     * @psalm-suppress ParamNameMismatch
     */
    public function writeln(iterable|string $messages, int $type = self::OUTPUT_NORMAL): void
    {
        if (is_iterable($messages)) {
            parent::writeln($messages, $type);

            return;
        }
        if ($this->isInSection) {
            $messages = '│ '.$messages;
        }
        parent::writeln($messages, $type);
    }

    public function createTable(): Table
    {
        $output = $this->output instanceof ConsoleOutputInterface ? $this->output->section() : $this->output;
        $style = clone Table::getStyleDefinition('borderless');
        $style->setCellHeaderFormat('<info>%s</info>');

        $emberNexusOutputWrapper = new EmberNexusOutputWrapper($output);

        return (new Table($emberNexusOutputWrapper))->setStyle($style);
    }

    public function createCompactTable(): Table
    {
        $output = $this->output instanceof ConsoleOutputInterface ? $this->output->section() : $this->output;
        $style = clone Table::getStyleDefinition('compact');
        $style->setCellHeaderFormat('<options=bold>%s</>');
        $style->setVerticalBorderChars('', ' ');

        $emberNexusOutputWrapper = new EmberNexusOutputWrapper($output);

        return (new Table($emberNexusOutputWrapper))->setStyle($style);
    }

    public function getLineLength(): int
    {
        return $this->lineLength;
    }

    public function createProgressBarInInteractiveTerminal(int $max = 0): ?ProgressBar
    {
        /**
         * @psalm-suppress RiskyTruthyFalsyComparison
         */
        if (getenv('TERM')) {
            return null;
        }

        return parent::createProgressBar($max);
    }
}
