<?php

namespace Brainvire\Task31_Product_Slider\Block\Adminhtml\Slider\Edit\Tab\Renderer;

use Magento\Catalog\Model\Category as CategoryModel;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Ui\Component\Product\Form\Categories\Options;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\Multiselect;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;

class Category extends Multiselect {

	public $collectionFactory;

	public $authorization;

	protected $_urlBuilder;

	protected $_option;

	public function __construct(
		Options $options,
		Factory $factoryElement,
		CollectionFactory $factoryCollection,
		Escaper $escaper,
		CategoryCollectionFactory $collectionFactory,
		AuthorizationInterface $authorization,
		UrlInterface $urlBuilder,
		array $data = []
	) {
		$this->_option = $options;
		$this->collectionFactory = $collectionFactory;
		$this->authorization = $authorization;
		$this->_urlBuilder = $urlBuilder;

		parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
	}

	public function getElementHtml() {
		$html = '<div class="admin__field-control admin__control-grouped" id="' . $this->getHtmlId() . '">';

		$html .= '<div id="slider-category-select" class="admin__field" data-bind="scope:\'sliderCategory\'" data-index="index">';
		$html .= '<!-- ko foreach: elems() -->';
		$html .= '<input name="slider[categories_ids]" data-bind="value: value" style="display: none"/>';
		$html .= '<!-- ko template: elementTmpl --><!-- /ko -->';
		$html .= '<!-- /ko -->';
		$html .= '</div>';

		$html .= '<div class="admin__field admin__field-group-additional admin__field-small" data-bind="scope:\'create_category_button\'">';
		$html .= '<div class="admin__field-control">';
		$html .= '<!-- ko template: elementTmpl --><!-- /ko -->';
		$html .= '</div></div></div>';

		$html .= '<!-- ko scope: \'create_category_modal\' --><!-- ko template: getTemplate() --><!-- /ko --><!-- /ko -->';

		$html .= $this->getScriptHtml();

		return $html;
	}

	public function getScriptHtml() {
		$html = '<script type="text/x-magento-init">
            {
                "*": {
                    "Magento_Ui/js/core/app": {
                        "components": {
                            "sliderCategory": {
                                "component": "uiComponent",
                                "children": {
                                    "slider_select_category": {
                                        "component": "Brainvire_Task31_Product_Slider/js/components/new-category",
                                        "config": {
                                            "filterOptions": true,
                                            "disableLabel": true,
                                            "chipsEnabled": true,
                                            "levelsVisibility": "1",
                                            "elementTmpl": "ui/grid/filters/elements/ui-select",
                                            "options": ' . json_encode($this->_option->toOptionArray()) . ',
                                            "value": ' . json_encode($this->getValues()) . ',
                                            "listens": {
                                                "index=create_category:responseData": "setParsed",
                                                "newOption": "toggleOptionSelected"
                                            },
                                            "config": {
                                                "dataScope": "slider_select_category",
                                                "sortOrder": 10
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        </script>';

		return $html;
	}

	public function getValues() {
		$values = $this->getValue();
		if (!is_array($values)) {
			$values = explode(',', $values);
		}

		if (!sizeof($values)) {
			return [];
		}

		$collection = $this->collectionFactory->create()
			->addIdFilter($values);

		$options = [];
		foreach ($collection as $category) {
			$options[] = $category->getId();
		}

		return $options;
	}

	public function getNoDisplay() {
		$isNotAllowed = !$this->authorization->isAllowed('Brainvire_Task31_Product_Slider::category');

		return $this->getData('no_display') || $isNotAllowed;
	}

	public function getCategoriesTree() {
		/* @var $collection Collection */
		$collection = $this->collectionFactory->create();
		$categoryById = [
			CategoryModel::TREE_ROOT_ID => [
				'value' => CategoryModel::TREE_ROOT_ID,
				'optgroup' => null,
			],
		];

		foreach ($collection as $category) {
			foreach ([$category->getId(), $category->getParentId()] as $categoryId) {
				if (!isset($categoryById[$categoryId])) {
					$categoryById[$categoryId] = ['value' => $categoryId];
				}
			}

			$categoryById[$category->getId()]['is_active'] = 1;
			$categoryById[$category->getId()]['label'] = $category->getName();
			$categoryById[$category->getParentId()]['optgroup'][] = &$categoryById[$category->getId()];
		}

		return $categoryById[CategoryModel::TREE_ROOT_ID]['optgroup'];
	}
}
