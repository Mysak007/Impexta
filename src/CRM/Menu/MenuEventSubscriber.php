<?php

declare(strict_types=1);

namespace App\CRM\Menu;

use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\User\Infrastructure\Security\AdminUserCrudVoter;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

final class MenuEventSubscriber implements EventSubscriberInterface
{
    private const ATTRIBUTE_ICON = 'icon';
    private const ICON_CAR = 'fas fa-car';
    private const ICON_ADMIN = 'fas fa-users-cog';
    private const ICON_LOGOUT = 'fas fa-sign-out-alt';
    private const ICON_DASHBOARD = 'fas fa-tachometer-alt';
    private const ICON_STORE = 'fas fa-building';
    private const ICON_ORDER = 'fas fa-shopping-cart';
    private const ICON_INQUIRY = 'fas fa-question';
    private const ICON_PRODUCT_CARD = 'far fa-clipboard';
    private const ICON_PRODUCT = 'fas fa-cash-register';
    private const ICON_PRODUCT_CATEGORY = 'fas fa-clipboard-list';
    private const ICON_WAREHOUSE = 'fas fa-warehouse';
    private const ICON_WAREHOUSE_INCOME = 'fas fa-clipboard-check';
    private const ICON_WAREHOUSE_ORDER = 'fas fa-cart-plus';
    private const ICON_SECOND_HAND_PRODUCT = 'fas fa-hand-holding-usd';
    private const ICON_CONTACT_FORM = 'fas fa-question';
    private const ICON_SHIPPING_PRICE_LIST = 'fas fa-shipping-fast';
    private const ICON_CLIENT = 'fas fa-users';
    private const ICON_CAR_MANUFACTURER = 'fas fa-industry';
    private const ICON_SETTINGS = 'fas fa-cogs';
    private const ICON_WAREHOUSEORDER_LIST = 'fas fa-cart-arrow-down';
    private const ICON_WAREHOUSEORDER_CREATE = 'far fa-plus-square';
    private const ICON_WAREHOUSEORDER_ARCHIVE_LIST = 'fas fa-clipboard-check';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @return array<string, array<int, int|string>>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KnpMenuEvent::class => ['onSetupMenu', 100],
        ];
    }

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function onSetupMenu(KnpMenuEvent $event): void
    {
        $menu = $event->getMenu();

        /* ### SECTION MENU ### */
        $menu->addChild(
            'menu',
            [
                'label' => 'Hlavní menu',
                'childOptions' => $event->getChildOptions(),
            ]
        )->setAttribute('class', 'header');

        // --- Dashboard --- //
        $menu->addChild(
            'crm_dashboard',
            [
                'label' => 'Přehled',
                'route' => 'crm_dashboard',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_DASHBOARD);
        // --- Dashboard end --- //

        //############################################################################################################\\

        /* ### SECTION SALE ### */
        $menu->addChild(
            'sale',
            [
                'label' => 'Prodej',
                'childOptions' => $event->getChildOptions(),
            ]
        )->setAttribute('class', 'header');

        // --- Orders list --- //
        $menu->addChild(
            'order_crm_order_list',
            [
                'label' => 'Objednávky',
                'route' => 'order_crm_order_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_ORDER);
        // --- Orders list end --- //

        // --- Inquiry list --- //
        $menu->addChild(
            'inquiry_crm_inquiry_list',
            [
                'label' => 'Poptávky',
                'route' => 'inquiry_crm_inquiry_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_INQUIRY);
        // --- Inquiry list end --- //

        //############################################################################################################\\

        /* ### SECTION PRODUCTS ### */
        $menu->addChild(
            'product',
            [
                'label' => 'Produkty',
                'childOptions' => $event->getChildOptions(),
            ]
        )->setAttribute('class', 'header');

        // --- ProductCard list --- //
        $menu->addChild(
            'product_crm_product_card_list',
            [
                'label' => 'Produktové karty',
                'route' => 'product_crm_product_card_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_PRODUCT_CARD);
        // --- ProductCard list end --- //

        // --- Product list --- //
        $menu->addChild(
            'product_crm_product_list',
            [
                'label' => 'Produkty',
                'route' => 'product_crm_product_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_PRODUCT);
        // --- Product list end --- //

        // --- Categories list --- //
        $menu->addChild(
            'product_crm_product_category_list',
            [
                'label' => 'Kategorie',
                'route' => 'product_crm_category_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_PRODUCT_CATEGORY);
        // --- Categories list end --- //

        // --- Warehouse --- //
        $menu->addChild(
            'warehouse_crm_warehouse',
            [
                'label' => 'Sklad',
                'childOptions' => $event->getChildOptions(),
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_WAREHOUSE);

        $menuChild = $menu->getChild('warehouse_crm_warehouse');

        if ($menuChild) {
            $menuChild->addChild(
                'prague',
                [
                    'label' => 'Praha',
                    'route' => 'warehouse_crm_warehouse_product_list',
                    'routeParameters' => ['warehouse' => Warehouse::PRAGUE],
                    'childOptions' => $event->getChildOptions(),
                ]
            );

            $menuChild->addChild(
                'ostrava',
                [
                    'label' => 'Ostrava',
                    'route' => 'warehouse_crm_warehouse_product_list',
                    'routeParameters' => ['warehouse' => Warehouse::OSTRAVA],
                    'childOptions' => $event->getChildOptions(),
                ]
            );

            $menuChild->addChild(
                'zilina',
                [
                    'label' => 'Žilina',
                    'route' => 'warehouse_crm_warehouse_product_list',
                    'routeParameters' => ['warehouse' => Warehouse::ZILINA],
                    'childOptions' => $event->getChildOptions(),
                ]
            );
        }

        // --- Warehouse end --- //

        // --- WarehouseIncome create --- //
        $menu->addChild(
            'warehouse_crm_warehouse_income',
            [
                'label' => 'Přijmout na sklad',
                'route' => 'warehouse_crm_warehouse_income',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_WAREHOUSE_INCOME);
        // --- WarehouseIncome create end --- //

        // --- Warehouse order --- //
        $menu->addChild(
            'warehouse_crm_warehouse_order_list',
            [
                'label' => 'Objednávky na sklad',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_WAREHOUSE_ORDER);

        $menuChild = $menu->getChild('warehouse_crm_warehouse_order_list');

        if ($menuChild) {
            $menuChild->addChild(
                'warehouse_crm_warehouse_order_list',
                [
                    'label' => 'Objednávky na sklad',
                    'route' => 'warehouse_crm_warehouse_order_list',
                ]
            )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_WAREHOUSEORDER_LIST);

            $menuChild->addChild(
                'warehouse_crm_warehouse_order_create',
                [
                    'label' => 'Založit objednávku',
                    'route' => 'warehouse_crm_warehouse_order_create',
                ]
            )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_WAREHOUSEORDER_CREATE);

            $menuChild->addChild(
                'warehouse_crm_warehouse_order_archive_list',
                [
                    'label' => 'Archiv objednávek',
                    'route' => 'warehouse_crm_warehouse_order_archive_list',
                ]
            )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_WAREHOUSEORDER_ARCHIVE_LIST);
        }

        // --- Warehouse order end --- //

        //############################################################################################################\\

        /* ### SECTION ESHOP ### */
        $menu->addChild(
            'eshop',
            [
                'label' => 'Eshop',
                'childOptions' => $event->getChildOptions(),
            ]
        )->setAttribute('class', 'header');

        // --- Second hand product list --- //
        $menu->addChild(
            'product_crm_second_hand_product_list',
            [
                'label' => 'Bazar',
                'route' => 'product_crm_second_hand_product_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_SECOND_HAND_PRODUCT);
        // --- Second hand product list end --- //

        // --- Stores list --- //
        $menu->addChild(
            'store_crm_store_list',
            [
                'label' => 'Pobočky',
                'route' => 'store_crm_store_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_STORE);
        // --- Stores list end --- //

        // --- ContactForm show --- //
        $menu->addChild(
            'contact_form_crm_contact_form_show',
            [
                'label' => 'Poptávkový formulář',
                'route' => 'contact_form_crm_contact_form_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_CONTACT_FORM);
        // --- ContactForm show end --- //

        // --- ShippingPrice list --- //
        $menu->addChild(
            'shipping_crm_shipping_price_list',
            [
                'label' => 'Ceník dopravy',
                'route' => 'shipping_crm_list_shipping_method_pricing',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_SHIPPING_PRICE_LIST);
        // --- ShippingPrice list end --- //

        //############################################################################################################\\

        /* ### SECTION USER ADMINISTRATION ### */
        $menu->addChild(
            'user',
            [
                'label' => 'Správa uživatelů',
                'childOptions' => $event->getChildOptions(),
            ]
        )->setAttribute('class', 'header');

        // --- Client list --- //
        $menu->addChild(
            'client_crm_client_list',
            [
                'label' => 'Klienti',
                'route' => 'client_crm_client_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_CLIENT);
        // --- Client list end --- //

        if ($this->security->isGranted(AdminUserCrudVoter::ACCESS, AdminUserInterface::class)) {
            // --- Admin list --- //
            $menu->addChild(
                'user_crm_admin_user_list',
                [
                    'label' => 'Administrátoři',
                    'route' => 'user_crm_admin_user_list',
                ]
            )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_ADMIN);
            // --- Admin list end --- //
        }

            // --- ShopUser list --- //
            $menu->addChild(
                'user_crm_shop_user_list',
                [
                    'label' => 'Uživatelé',
                    'route' => 'user_crm_shop_user_list',
                ]
            )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_CLIENT);
            // --- ShopUser list end --- //

        //############################################################################################################\\

        /* ### SECTION CARS ### */
        $menu->addChild(
            'car',
            [
                'label' => 'Vozidla',
                'childOptions' => $event->getChildOptions(),
            ]
        )->setAttribute('class', 'header');

        // --- CarManufacturer list --- //
        $menu->addChild(
            'car_crm_car_manufacturer_list',
            [
                'label' => 'Výrobci',
                'route' => 'car_crm_car_manufacturer_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_CAR_MANUFACTURER);
        // --- CarManufacturer list end --- //


        // --- Car list --- //
        $menu->addChild(
            'car_crm_car_list',
            [
                'label' => 'Seznam vozidel',
                'route' => 'car_crm_car_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_CAR);
        // --- Car list end --- //

        //############################################################################################################\\

        /* ### SECTION SERVICE ### */
        $menu->addChild(
            'service',
            [
                'label' => 'Autoservis',
                'childOptions' => $event->getChildOptions(),
            ]
        )->setAttribute('class', 'header');

        // --- Car list --- //
        $menu->addChild(
            'car_service_crm_car_service_list',
            [
                'label' => 'Seznam zakázek',
                'route' => 'car_service_crm_car_service_list',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_CAR);
        // --- Car list end --- //

        //############################################################################################################\\

        /* ### SECTION MY ACCOUNT ### */
        $menu->addChild(
            'my_account',
            [
                'label' => 'Můj účet',
                'childOptions' => $event->getChildOptions(),
            ]
        )->setAttribute('class', 'header');

        // --- Settings --- //
        // --- Logout --- //
        $menu->addChild(
            'something_crm_settings_show',
            [
                'label' => 'Nastavení',
                'route' => '',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_SETTINGS);
        // --- Settings end --- //

        // --- Logout --- //
        $menu->addChild(
            'logout',
            [
                'label' => 'Odhlásit se',
                'route' => 'user_crm_security_admin_user_logout',
            ]
        )->setLabelAttribute(self::ATTRIBUTE_ICON, self::ICON_LOGOUT);
        // --- Logout end --- //
    }
    // --- Logout end --- //
}
