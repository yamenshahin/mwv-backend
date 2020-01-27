<?php

namespace App\Http\Controllers\AdminAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DynamicPage;

use \SimpleXMLElement;


class SiteMapDynamicPageController extends Controller
{
    public static function generateSitemap()
    {
        $dynamic_pages = DynamicPage::select('*')
        ->orderBy('id', 'desc')
        ->get()->toArray();

        $xml_string = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach($dynamic_pages as $dynamic_page) {
            $xml_string .= '<url>';

            if ($dynamic_page['parent_slug'] === 'index') {
                $xml_string .= '<loc>https://hellovans.com/' . $dynamic_page['slug'] . '/</loc>';
            } else {
                $xml_string .= '<loc>https://hellovans.com/' . $dynamic_page['parent_slug'] . '/' . $dynamic_page['slug'] . '/' . '</loc>';
            }
            

            $xml_string .= '<lastmod>' . date('c',strtotime($dynamic_page['updated_at'])) . '</lastmod>';

            $xml_string .= '<changefreq>daily</changefreq>';

            $xml_string .= '<priority>0.8</priority>';

            $xml_string .= '</url>';
        }

        $xml_string .= '</urlset>';

        $xml= new SimpleXMLElement($xml_string);

        $xml->asXML('sitemap.xml');
    }
}
