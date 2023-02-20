<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Mustache helper render pix icons.
 *
 * This class is only required if a Totara environment is detected.
 * Moodle has its own equivalent in lib/classes/output on which this is heavily based.
 * Totara does not have this, hence including it here so we can use {{#ftpix}} in mustache.
 *
 * @package    core
 * @category   output
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace format_tiles\output;
defined('MOODLE_INTERNAL') || die();
use Mustache_LambdaHelper;
use renderer_base;

/**
 * This class will call pix_icon with the section content.
 *
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      2.9
 */
class mustache_pix_helper {

    /** @var renderer_base $renderer A reference to the renderer in use */
    private $renderer;

    /**
     * Save a reference to the renderer.
     * @param renderer_base $renderer
     */
    public function __construct(renderer_base $renderer) {
        $this->renderer = $renderer;
    }

    /**
     * Read a pix icon name from a template and get it from pix_icon.
     *
     * {{#ftpix}}t/edit,component,Anything else is alt text{{/ftpix}}
     *
     * The args are comma separated and only the first is required.
     *
     * @param string $text The text to parse for arguments.
     * @param Mustache_LambdaHelper $helper Used to render nested mustache variables.
     * @return string
     */
    public function ftpix($text, Mustache_LambdaHelper $helper) {
        // Split the text into an array of variables.
        $key = strtok($text, ",");
        $key = trim($helper->render($key));

        $component = strtok(",");
        $component = trim($helper->render($component));
        if (!$component) {
            $component = '';
        }
        $component = $helper->render($component);
        $text = strtok("");
        // Allow mustache tags in the last argument.
        $text = trim($helper->render($text));

        return trim($this->renderer->pix_icon($key, $text, $component));
    }
}
