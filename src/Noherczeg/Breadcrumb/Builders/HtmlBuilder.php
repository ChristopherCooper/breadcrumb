<?php namespace Noherczeg\Breadcrumb\Builders;

class HtmlBuilder extends Builder
{
    /**
     * build: The builder method which creates HTML style breadcrumbs
     * 
     * @param String|null $casing       Casing option
     * @param boolean $last_not_link    True if last shouldn't be a link
     * @param String|null $separator    Separator String
     * @param array $customizations     Array of properties + values
     * @return String
     */
    public function build ($casing = null, $last_not_link = true, $separator = null, $properties = array(), $different_links = flase)
    {
        // always create link on build stage!
        $this->link($last_not_link, $different_links);
        
        // handle defaults
        (is_null($separator))   ? $ts = $this->config->value('separator')      : $ts = $separator;
        (is_null($casing))      ? $tc = $this->config->value('casing') : $tc = $casing;
        
        $result = '';
        
        foreach ($this->segments AS $key => $segment)
		{
            
            // ignore separator after the last element
            if ($key > 0) {
                $result .= $ts;
            }
            
			if ($segment->get('disabled')) {
				$result .= $this->getInactiveElementByFieldName($segment->get('raw'), $tc, $this->properties($properties));
			} else if (is_null($segment->get('link'))) {
				$result .= $this->getInactiveElementByFieldName($segment->get('translated'), $tc, $this->properties($properties));
			} else {
				$result .= '<a href="' . $segment->get('link') . '" ' . $this->properties($properties) . '>' . $this->casing($segment->get('translated'), $tc) . '</a>';
			}
		}

		return $result;
    }
	
	private function getInactiveElementByFieldName($segmentProperty, $tc, $htmlProperties)
	{
		return '<span' . $htmlProperties . '>' . $this->casing($segmentProperty, $tc) . '</span>';
	}
}
