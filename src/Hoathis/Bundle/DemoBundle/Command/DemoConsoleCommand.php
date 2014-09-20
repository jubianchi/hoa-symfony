<?php
namespace Hoathis\Bundle\DemoBundle\Command;

use Hoathis\SymfonyConsoleBridge\Helper\CursorHelper;
use Hoathis\SymfonyConsoleBridge\Helper\ReadlineHelper;
use Hoathis\SymfonyConsoleBridge\Helper\WindowHelper;
use Hoathis\SymfonyConsoleBridge\Formatter\OutputFormatterStyle;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DemoConsoleCommand extends ContainerAwareCommand
{
    public function __construct($name = null)
    {
        parent::__construct($name ?: 'hoathis:demo:console');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cursor = $this->getHelper('cursor');
        $window = $this->getHelper('window');
        $readline = $this->getHelper('readline');
        $pager = $this->getHelper('pager');
        $tput = $this->getHelper('tput');

        $window->setTitle($output, $title = ($this->getApplication()->getName() . ' - ' . $this->getApplication()->getVersion()));

        while (true) {
            $action = $readline->select(
                $output,
                'Qu\'est-ce que vous souhaitez faire ?',
                array(
                    '<title> -- Window </title>' => ReadlineHelper::SEPARATOR,
                    'window.resize' => 'Redimensionne la fenêtre',
                    'window.size' => 'Redimensionne la fenêtre',
                    'window.minimize' => 'Réduire la fenêtre',
                    'window.restore' => 'Restaurer la fenêtre',
                    'window.lower' => 'Masquer la fenêtre',
                    'window.raise' => 'Agrandir la fenêtre',
                    'window.label' => 'Affiche le libellé de la fenêtre',
                    'window.title' => 'Affiche et change le titre de la fenêtre',
                    'window.scroll' => 'Fait défiler la fenêtre',
                    'window.position' => 'Affiche la position de la fenêtre',

                    '<title> -- Style </title>' => ReadlineHelper::SEPARATOR,
                    'style.error' => 'Affiche un message d\'erreur',
                    'style.info' => 'Affiche un message d\'info',
                    'style.comment' => 'Affiche un commentaire',
                    'style.question' => 'Affiche une question',

                    '<title> -- Cursor </title>' => ReadlineHelper::SEPARATOR,
                    'cursor.hide' => 'Cache le curseur',
                    'cursor.show' => 'Affiche le curseur',
                    'cursor.bip' => 'Emet un bip',

                    '<title> -- Cursor style </title>' => ReadlineHelper::SEPARATOR,
                    'cursor.block' => 'Définit le style du curseur ' . CursorHelper::STYLE_BLOCK,
                    'cursor.block.blink' => 'Définit le style du curseur clignotant ' . CursorHelper::STYLE_BLOCK,
                    'cursor.vertical' => 'Définit le style du curseur ' . CursorHelper::STYLE_VERTICAL,
                    'cursor.vertical.blink' => 'Définit le style du curseur clignotant ' . CursorHelper::STYLE_VERTICAL,
                    'cursor.underline' => 'Définit le style du curseur ' . CursorHelper::STYLE_UNDERLINE,
                    'cursor.underline.blink' => 'Définit le style du curseur clignotant ' . CursorHelper::STYLE_UNDERLINE,
                    'cursor.colorize' => 'Applique un style au text',

                    '<title> -- Cursor moves </title>' => ReadlineHelper::SEPARATOR,
                    'cursor.animate' => 'Fait bouger le curseur',
                    'cursor.position' => 'Affiche la position de la fenêtre',

                    '<title> -- Pager </title>' => ReadlineHelper::SEPARATOR,
                    'pager.less' => 'Pagination de la sortie à l\'aide de less',
                    'pager.more' => 'Pagination de la sortie à l\'aide de more',

                    '<title> -- Tput </title>' => ReadlineHelper::SEPARATOR,
                    'tput.get' => 'Demande une information à tput',

                    ReadlineHelper::SEPARATOR,
                    'quit' => 'Quitte l\'application',
                    'clear' => 'Vide l\'écran',
                ),
                null,
                true
            );

            switch ($action) {
                case 'window.minimize':
                case 'window.restore':
                case 'window.lower':
                case 'window.raise':
                    $method = str_replace('window.', '', $action);
                    $window->{$method}($output);
                    break;

                case 'window.label':
                    $output->writeln($window->getLabel($output));
                    break;

                case 'window.title':
                    if($title) {
                        $output->writeln('Le titre actuel est : ' . $title);
                    }

                    $window->setTitle($output, $title = $readline->read($output, 'Nouveau titre : ', $title));
                    break;

                case 'window.resize':
                    $width = $readline->read($output, 'Largeur : ');
                    $height = $readline->read($output, 'Hauteur : ');

                    $window->setSize($output, $width, $height);
                    break;

                case 'window.size':
                    $size = $window->getSize($output);
                    $output->writeln(sprintf('<comment>width:</comment> <info>%d</info> / <comment>height:</comment> <info>%d</info>', $size['x'], $size['y']));
                    break;

                case 'window.scroll':
                    for($i = 0; $i < 10; $i++) {
                        $window->scroll($output, WindowHelper::SCROLL_UP);
                        usleep(125000);
                    }
                    usleep(250000);
                    for($i = 0; $i < 10; $i++) {
                        $window->scroll($output, WindowHelper::SCROLL_DOWN);
                        usleep(125000);
                    }
                    break;

                case 'window.position':
                    $position = $window->getPosition($output);
                    $output->writeln(sprintf('<comment>x:</comment> <info>%d</info> / <comment>y:</comment> <info>%d</info>', $position['x'], $position['y']));
                    break;

                case 'style.error':
                case 'style.info':
                case 'style.comment':
                case 'style.question':
                    $style = str_replace('style.', '', $action);
                    $output->writeln(sprintf('<%s> Ceci est un message avec le style \<%1$s/> </%1$s>', $style));
                    break;

                case 'cursor.bip':
                case 'cursor.show':
                case 'cursor.hide':
                    $method = str_replace('cursor.', '', $action);
                    $cursor->{$method}($output);
                    break;

                case 'cursor.block':
                case 'cursor.block.blink':
                    $cursor->style($output, CursorHelper::STYLE_BLOCK, ($action === 'cursor.block.blink'));
                    break;
                case 'cursor.vertical':
                case 'cursor.vertical.blink':
                    $cursor->style($output, CursorHelper::STYLE_VERTICAL, ($action === 'cursor.vertical.blink'));
                    break;
                case 'cursor.underline':
                case 'cursor.underline.blink':
                    $cursor->style($output, CursorHelper::STYLE_UNDERLINE, ($action === 'cursor.underline.blink'));
                    break;

                case 'cursor.animate':
                    $output->write(PHP_EOL);
                    $output->write(PHP_EOL);

                    $cursor->move($output, CursorHelper::MOVE_UP);

                    for ($i = 0; $i < 3; $i++) {
                        $cursor->move($output, CursorHelper::MOVE_UP);
                        usleep(125000);
                        $cursor->move($output, CursorHelper::MOVE_RIGHT);
                        usleep(125000);
                        $cursor->move($output, CursorHelper::MOVE_DOWN);
                        usleep(125000);
                        $cursor->move($output, CursorHelper::MOVE_RIGHT);
                        usleep(125000);
                    }
                    usleep(125000);
                    for ($i = 0; $i < 3; $i++) {
                        $cursor->move($output, CursorHelper::MOVE_UP);
                        usleep(125000);
                        $cursor->move($output, CursorHelper::MOVE_LEFT);
                        usleep(125000);
                        $cursor->move($output, CursorHelper::MOVE_DOWN);
                        usleep(125000);
                        $cursor->move($output, CursorHelper::MOVE_LEFT);
                        usleep(125000);
                    }
                    $cursor->move($output, CursorHelper::MOVE_UP);
                    usleep(125000);
                    break;

                case 'cursor.colorize':
                    $fg = $readline->read($output, 'Couleur du texte (<comment>nom, code hexa, valeur numérique</comment>) : ');
                    $bg = $readline->read($output, 'Couleur de fond (<comment>nom, code hexa, valeur numérique</comment>) : ');
                    $opts = $readline->select(
                        $output,
                        'Options ',
                        array(
                            '' => 'Aucun',
                            'n' => 'Normal',
                            'u' => 'Souligné (underline)',
                            'b' => 'Gras (bold)',
                            'bl' => 'Clignotant (blink)',
                            'i' => 'Inversé (inverse)'
                        ),
                        '',
                        true,
                        true
                    );
                    $text = $readline->read($output, 'Text : ');

                    if(trim($opts) !== '') {
                        $opts = explode(' ', $opts);
                    } else {
                        $opts = array();
                    }

                    $output->getFormatter()->setStyle('colorize', $style = new OutputFormatterStyle($fg, $bg, $opts));
                    $output->writeln(
                        sprintf(
                            '<colorize> %s (%s) </colorize>',
                            $text,
                            sprintf('fg(%s) bg(%s)%s', $fg, $bg, implode(' ', $opts))
                        )
                    );
                    break;

                case 'cursor.position':
                    $position = $cursor->getPosition();
                    $output->writeln(sprintf('<comment>x:</comment> <info>%d</info> / <comment>y:</comment> <info>%d</info>', $position['x'], $position['y']));
                    break;

                case 'pager.less':
                case 'pager.more':
                    $type = str_replace('pager.', '', $action);

                    $formatter = $output->getFormatter();
                    $styles = array(
                        'title',
                        'comment',
                        'info',
                        'error'
                    );

                    $pager->$type($output, function() use ($styles, $formatter) {
                        for ($i = 0; $i < 50; $i++) {
                            $style = $styles[rand(0, count($styles) - 1)];
                            echo $formatter->format('<' . $style . '>' . uniqid() . '</' . $style . '>') . PHP_EOL;
                        }
                    }, true);
                    break;

                case 'tput.get':
                    $name = $readline->read($output, 'Identifiant : ');
                    $output->writeln(sprintf('<comment>%s:</comment> <info>%s</info>', $name, $tput->get($name)));
                    break;

                case 'clear':
                    $cursor->clear($output, CursorHelper::CLEAR_SCREEN);
                    break;

                case 'quit':
                    return 0;
            }
        }
    }
} 
