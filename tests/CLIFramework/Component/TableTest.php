<?php
use CLIFramework\Component\Table;
use CLIFramework\Component\TableStyle;
use CLIFramework\Component\CellAttribute;
use CLIFramework\Component\MarkdownTableStyle;

class TableTest extends PHPUnit_Framework_TestCase
{


    public function testCustomColumnCellAttribute() 
    {
        $highlight = new CellAttribute;
        $highlight->setBackgroundColor('blue');

        $table = new Table;
        $table->addRow(array( 
            "September 16, 2014",
            ["Zero to One: Notes on Startups, or How to Build the Future", $highlight],
            "If you want to build a better future, you must believe in secrets.
            The great secret of our time is that there are still uncharted frontiers to explore and new inventions to create. In Zero to One, legendary entrepreneur and investor Peter Thiel shows how we can find singular ways to create those new things. ",
        ));
        // echo "\n" . $table->render() . "\n";
        $this->assertStringEqualsFile('tests/data/default-table-cell-attribute.txt', $table);
    }

    static public function assertStringEqualsFile($file, $str, $message = NULL, $canonicalize = false, $ignoreCase = false) {
        if ($str instanceof Table) {
            $str = $str->render();
        }
        if (!file_exists($file)) {
            file_put_contents($file, $str);
        }
        parent::assertStringEqualsFile($file, $str, $message, $canonicalize, $ignoreCase);
    }

    public function testDefaultTableWithTextOverflowWithoutHeaderAndFooter()
    {
        $table = new Table;
        $table->setMaxColumnWidth(30);
        $table->getDefaultCellAttribute()->setTextOverflow('ellipsis');
        $table->addRow(array( 
            "September 16, 2014",
            "Zero to One: Notes on Startups, or How to Build the Future",
            "If you want to build a better future, you must believe in secrets.
            The great secret of our time is that there are still uncharted frontiers to explore and new inventions to create. In Zero to One, legendary entrepreneur and investor Peter Thiel shows how we can find singular ways to create those new things. ",
        ));

        $out = $table->render();
        $this->assertStringEqualsFile('tests/data/default-table-2.txt', $out);
    }



    public function testDefaultTableWithoutFooter()
    {
        $table = new Table;
        $table->setHeaders(array(
            'Published Date',
            'Title',
            'Description',
        ));
        $table->addRow(array( 
            "September 16, 2014",
            "Zero to One: Notes on Startups, or How to Build the Future",
            "If you want to build a better future, you must believe in secrets.
            The great secret of our time is that there are still uncharted frontiers to explore and new inventions to create. In Zero to One, legendary entrepreneur and investor Peter Thiel shows how we can find singular ways to create those new things. ",
        ));
        $table->addRow(array( 
            "November 4, 2014",
            "Hooked: How to Build Habit-Forming Products",

            "Why do some products capture widespread attention while others flop? What makes us engage with certain products out of sheer habit? Is there a pattern underlying how technologies hook us? "
            . "Nir Eyal answers these questions (and many more) by explaining the Hook Model—a four-step process embedded into the products of many successful companies to subtly encourage customer behavior. Through consecutive “hook cycles,” these products reach their ultimate goal of bringing users back again and again without depending on costly advertising or aggressive messaging.\n"
        ));
        $out = $table->render();
        $this->assertStringEqualsFile('tests/data/default-table.txt', $out);
    }


    public function testDefaultTableWithFooter()
    {
        $table = new Table;
        $table->setHeaders(array(
            'Published Date',
            'Title',
            'Description',
        ));
        $table->addRow(array( 
            "September 16, 2014",
            "Zero to One: Notes on Startups, or How to Build the Future",
            "If you want to build a better future, you must believe in secrets.
            The great secret of our time is that there are still uncharted frontiers to explore and new inventions to create. In Zero to One, legendary entrepreneur and investor Peter Thiel shows how we can find singular ways to create those new things. ",
        ));
        $table->addRow(array( 
            "November 4, 2014",
            "Hooked: How to Build Habit-Forming Products",

            "Why do some products capture widespread attention while others flop? What makes us engage with certain products out of sheer habit? Is there a pattern underlying how technologies hook us? "
            . "Nir Eyal answers these questions (and many more) by explaining the Hook Model—a four-step process embedded into the products of many successful companies to subtly encourage customer behavior. Through consecutive “hook cycles,” these products reach their ultimate goal of bringing users back again and again without depending on costly advertising or aggressive messaging.\n"
        ));
        $table->setFooter('Found 3 books...');
        $out = $table->render();
        $this->assertStringEqualsFile('tests/data/default-table-footer.txt', $out);
    }


    public function testMarkdownTable()
    {
        $table = new Table;
        $table->setStyle(new MarkdownTableStyle);
        $table->setHeaders(array(
            'Published Date',
            'Title',
            'Description',
        ));
        $table->addRow(array( 
            "September 16, 2014",
            "Zero to One: Notes on Startups, or How to Build the Future",
            "If you want to build a better future, you must believe in secrets.
            The great secret of our time is that there are still uncharted frontiers to explore and new inventions to create. In Zero to One, legendary entrepreneur and investor Peter Thiel shows how we can find singular ways to create those new things. ",
        ));
        $table->addRow(array( 
            "November 4, 2014",
            "Hooked: How to Build Habit-Forming Products",

            "Why do some products capture widespread attention while others flop? What makes us engage with certain products out of sheer habit? Is there a pattern underlying how technologies hook us? "
            . "Nir Eyal answers these questions (and many more) by explaining the Hook Model—a four-step process embedded into the products of many successful companies to subtly encourage customer behavior. Through consecutive “hook cycles,” these products reach their ultimate goal of bringing users back again and again without depending on costly advertising or aggressive messaging.\n"
        ));
        $table->setFooter('Found 3 books...');
        $out = $table->render();
        $this->assertStringEqualsFile('tests/data/markdown-table.txt', $out);
    }
}
