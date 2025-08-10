<?php

namespace Nirbose\PhpMcServ\Block;

use Exception;
use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Type\Anvil;
use Nirbose\PhpMcServ\Block\Type\Barrel;
use Nirbose\PhpMcServ\Block\Type\Bed;
use Nirbose\PhpMcServ\Block\Type\Chest;
use Nirbose\PhpMcServ\Block\Type\Composter;
use Nirbose\PhpMcServ\Block\Type\Door;
use Nirbose\PhpMcServ\Block\Type\Fence;
use Nirbose\PhpMcServ\Block\Type\GenericBisected;
use Nirbose\PhpMcServ\Block\Type\GenericBlockData;
use Nirbose\PhpMcServ\Block\Type\GenericOrientable;
use Nirbose\PhpMcServ\Block\Type\GenericSnowy;
use Nirbose\PhpMcServ\Block\Type\GlassPane;
use Nirbose\PhpMcServ\Block\Type\Sign;
use Nirbose\PhpMcServ\Block\Type\Slab;
use Nirbose\PhpMcServ\Block\Type\Stairs;
use Nirbose\PhpMcServ\Material;
use Pest\Exceptions\FatalException;

enum BlockType
{
    case ACACIA_BUTTON;
    case ACACIA_DOOR;
    case ACACIA_FENCE;
    case ACACIA_FENCE_GATE;
    case ACACIA_HANGING_SIGN;
    case ACACIA_LEAVES;
    case ACACIA_LOG;
    case ACACIA_PLANKS;
    case ACACIA_PRESSURE_PLATE;
    case ACACIA_SAPLING;
    case ACACIA_SIGN;
    case ACACIA_SLAB;
    case ACACIA_STAIRS;
    case ACACIA_TRAPDOOR;
    case ACACIA_WALL_HANGING_SIGN;
    case ACACIA_WALL_SIGN;
    case ACACIA_WOOD;
    case ACTIVATOR_RAIL;
    case AIR;
    case ALLIUM;
    case AMETHYST_BLOCK;
    case AMETHYST_CLUSTER;
    case ANCIENT_DEBRIS;
    case ANDESITE;
    case ANDESITE_SLAB;
    case ANDESITE_STAIRS;
    case ANDESITE_WALL;
    case ANVIL;
    case ATTACHED_MELON_STEM;
    case ATTACHED_PUMPKIN_STEM;
    case AZALEA;
    case AZALEA_LEAVES;
    case AZURE_BLUET;
    case BAMBOO;
    case BAMBOO_BLOCK;
    case BAMBOO_BUTTON;
    case BAMBOO_DOOR;
    case BAMBOO_FENCE;
    case BAMBOO_FENCE_GATE;
    case BAMBOO_HANGING_SIGN;
    case BAMBOO_MOSAIC;
    case BAMBOO_MOSAIC_SLAB;
    case BAMBOO_MOSAIC_STAIRS;
    case BAMBOO_PLANKS;
    case BAMBOO_PRESSURE_PLATE;
    case BAMBOO_SAPLING;
    case BAMBOO_SIGN;
    case BAMBOO_SLAB;
    case BAMBOO_STAIRS;
    case BAMBOO_TRAPDOOR;
    case BAMBOO_WALL_HANGING_SIGN;
    case BAMBOO_WALL_SIGN;
    case BARREL;
    case BARRIER;
    case BASALT;
    case BEACON;
    case BEDROCK;
    case BEE_NEST;
    case BEEHIVE;
    case BEETROOTS;
    case BELL;
    case BIG_DRIPLEAF;
    case BIG_DRIPLEAF_STEM;
    case BIRCH_BUTTON;
    case BIRCH_DOOR;
    case BIRCH_FENCE;
    case BIRCH_FENCE_GATE;
    case BIRCH_HANGING_SIGN;
    case BIRCH_LEAVES;
    case BIRCH_LOG;
    case BIRCH_PLANKS;
    case BIRCH_PRESSURE_PLATE;
    case BIRCH_SAPLING;
    case BIRCH_SIGN;
    case BIRCH_SLAB;
    case BIRCH_STAIRS;
    case BIRCH_TRAPDOOR;
    case BIRCH_WALL_HANGING_SIGN;
    case BIRCH_WALL_SIGN;
    case BIRCH_WOOD;
    case BLACK_BANNER;
    case BLACK_BED;
    case BLACK_CANDLE;
    case BLACK_CANDLE_CAKE;
    case BLACK_CARPET;
    case BLACK_CONCRETE;
    case BLACK_CONCRETE_POWDER;
    case BLACK_GLAZED_TERRACOTTA;
    case BLACK_SHULKER_BOX;
    case BLACK_STAINED_GLASS;
    case BLACK_STAINED_GLASS_PANE;
    case BLACK_TERRACOTTA;
    case BLACK_WALL_BANNER;
    case BLACK_WOOL;
    case BLACKSTONE;
    case BLACKSTONE_SLAB;
    case BLACKSTONE_STAIRS;
    case BLACKSTONE_WALL;
    case BLAST_FURNACE;
    case BLUE_BANNER;
    case BLUE_BED;
    case BLUE_CANDLE;
    case BLUE_CANDLE_CAKE;
    case BLUE_CARPET;
    case BLUE_CONCRETE;
    case BLUE_CONCRETE_POWDER;
    case BLUE_GLAZED_TERRACOTTA;
    case BLUE_ICE;
    case BLUE_ORCHID;
    case BLUE_SHULKER_BOX;
    case BLUE_STAINED_GLASS;
    case BLUE_STAINED_GLASS_PANE;
    case BLUE_TERRACOTTA;
    case BLUE_WALL_BANNER;
    case BLUE_WOOL;
    case BONE_BLOCK;
    case BOOKSHELF;
    case BRAIN_CORAL;
    case BRAIN_CORAL_BLOCK;
    case BRAIN_CORAL_FAN;
    case BRAIN_CORAL_WALL_FAN;
    case BREWING_STAND;
    case BRICK_SLAB;
    case BRICK_STAIRS;
    case BRICK_WALL;
    case BRICKS;
    case BROWN_BANNER;
    case BROWN_BED;
    case BROWN_CANDLE;
    case BROWN_CANDLE_CAKE;
    case BROWN_CARPET;
    case BROWN_CONCRETE;
    case BROWN_CONCRETE_POWDER;
    case BROWN_GLAZED_TERRACOTTA;
    case BROWN_MUSHROOM;
    case BROWN_MUSHROOM_BLOCK;
    case BROWN_SHULKER_BOX;
    case BROWN_STAINED_GLASS;
    case BROWN_STAINED_GLASS_PANE;
    case BROWN_TERRACOTTA;
    case BROWN_WALL_BANNER;
    case BROWN_WOOL;
    case BUBBLE_COLUMN;
    case BUBBLE_CORAL;
    case BUBBLE_CORAL_BLOCK;
    case BUBBLE_CORAL_FAN;
    case BUBBLE_CORAL_WALL_FAN;
    case BUDDING_AMETHYST;
    case BUSH;
    case CACTUS;
    case CACTUS_FLOWER;
    case CAKE;
    case CALCITE;
    case CALIBRATED_SCULK_SENSOR;
    case CAMPFIRE;
    case CANDLE;
    case CANDLE_CAKE;
    case CARROTS;
    case CARTOGRAPHY_TABLE;
    case CARVED_PUMPKIN;
    case CAULDRON;
    case CAVE_AIR;
    case CAVE_VINES;
    case CAVE_VINES_PLANT;
    case CHAIN;
    case CHAIN_COMMAND_BLOCK;
    case CHERRY_BUTTON;
    case CHERRY_DOOR;
    case CHERRY_FENCE;
    case CHERRY_FENCE_GATE;
    case CHERRY_HANGING_SIGN;
    case CHERRY_LEAVES;
    case CHERRY_LOG;
    case CHERRY_PLANKS;
    case CHERRY_PRESSURE_PLATE;
    case CHERRY_SAPLING;
    case CHERRY_SIGN;
    case CHERRY_SLAB;
    case CHERRY_STAIRS;
    case CHERRY_TRAPDOOR;
    case CHERRY_WALL_HANGING_SIGN;
    case CHERRY_WALL_SIGN;
    case CHERRY_WOOD;
    case CHEST;
    case CHIPPED_ANVIL;
    case CHISELED_BOOKSHELF;
    case CHISELED_COPPER;
    case CHISELED_DEEPSLATE;
    case CHISELED_NETHER_BRICKS;
    case CHISELED_POLISHED_BLACKSTONE;
    case CHISELED_QUARTZ_BLOCK;
    case CHISELED_RED_SANDSTONE;
    case CHISELED_RESIN_BRICKS;
    case CHISELED_SANDSTONE;
    case CHISELED_STONE_BRICKS;
    case CHISELED_TUFF;
    case CHISELED_TUFF_BRICKS;
    case CHORUS_FLOWER;
    case CHORUS_PLANT;
    case CLAY;
    case CLOSED_EYEBLOSSOM;
    case COAL_BLOCK;
    case COAL_ORE;
    case COARSE_DIRT;
    case COBBLED_DEEPSLATE;
    case COBBLED_DEEPSLATE_SLAB;
    case COBBLED_DEEPSLATE_STAIRS;
    case COBBLED_DEEPSLATE_WALL;
    case COBBLESTONE;
    case COBBLESTONE_SLAB;
    case COBBLESTONE_STAIRS;
    case COBBLESTONE_WALL;
    case COBWEB;
    case COCOA;
    case COMMAND_BLOCK;
    case COMPARATOR;
    case COMPOSTER;
    case CONDUIT;
    case COPPER_BLOCK;
    case COPPER_BULB;
    case COPPER_DOOR;
    case COPPER_GRATE;
    case COPPER_ORE;
    case COPPER_TRAPDOOR;
    case CORNFLOWER;
    case CRACKED_DEEPSLATE_BRICKS;
    case CRACKED_DEEPSLATE_TILES;
    case CRACKED_NETHER_BRICKS;
    case CRACKED_POLISHED_BLACKSTONE_BRICKS;
    case CRACKED_STONE_BRICKS;
    case CRAFTER;
    case CRAFTING_TABLE;
    case CREAKING_HEART;
    case CREEPER_HEAD;
    case CREEPER_WALL_HEAD;
    case CRIMSON_BUTTON;
    case CRIMSON_DOOR;
    case CRIMSON_FENCE;
    case CRIMSON_FENCE_GATE;
    case CRIMSON_FUNGUS;
    case CRIMSON_HANGING_SIGN;
    case CRIMSON_HYPHAE;
    case CRIMSON_NYLIUM;
    case CRIMSON_PLANKS;
    case CRIMSON_PRESSURE_PLATE;
    case CRIMSON_ROOTS;
    case CRIMSON_SIGN;
    case CRIMSON_SLAB;
    case CRIMSON_STAIRS;
    case CRIMSON_STEM;
    case CRIMSON_TRAPDOOR;
    case CRIMSON_WALL_HANGING_SIGN;
    case CRIMSON_WALL_SIGN;
    case CRYING_OBSIDIAN;
    case CUT_COPPER;
    case CUT_COPPER_SLAB;
    case CUT_COPPER_STAIRS;
    case CUT_RED_SANDSTONE;
    case CUT_RED_SANDSTONE_SLAB;
    case CUT_SANDSTONE;
    case CUT_SANDSTONE_SLAB;
    case CYAN_BANNER;
    case CYAN_BED;
    case CYAN_CANDLE;
    case CYAN_CANDLE_CAKE;
    case CYAN_CARPET;
    case CYAN_CONCRETE;
    case CYAN_CONCRETE_POWDER;
    case CYAN_GLAZED_TERRACOTTA;
    case CYAN_SHULKER_BOX;
    case CYAN_STAINED_GLASS;
    case CYAN_STAINED_GLASS_PANE;
    case CYAN_TERRACOTTA;
    case CYAN_WALL_BANNER;
    case CYAN_WOOL;
    case DAMAGED_ANVIL;
    case DANDELION;
    case DARK_OAK_BUTTON;
    case DARK_OAK_DOOR;
    case DARK_OAK_FENCE;
    case DARK_OAK_FENCE_GATE;
    case DARK_OAK_HANGING_SIGN;
    case DARK_OAK_LEAVES;
    case DARK_OAK_LOG;
    case DARK_OAK_PLANKS;
    case DARK_OAK_PRESSURE_PLATE;
    case DARK_OAK_SAPLING;
    case DARK_OAK_SIGN;
    case DARK_OAK_SLAB;
    case DARK_OAK_STAIRS;
    case DARK_OAK_TRAPDOOR;
    case DARK_OAK_WALL_HANGING_SIGN;
    case DARK_OAK_WALL_SIGN;
    case DARK_OAK_WOOD;
    case DARK_PRISMARINE;
    case DARK_PRISMARINE_SLAB;
    case DARK_PRISMARINE_STAIRS;
    case DAYLIGHT_DETECTOR;
    case DEAD_BRAIN_CORAL;
    case DEAD_BRAIN_CORAL_BLOCK;
    case DEAD_BRAIN_CORAL_FAN;
    case DEAD_BRAIN_CORAL_WALL_FAN;
    case DEAD_BUBBLE_CORAL;
    case DEAD_BUBBLE_CORAL_BLOCK;
    case DEAD_BUBBLE_CORAL_FAN;
    case DEAD_BUBBLE_CORAL_WALL_FAN;
    case DEAD_BUSH;
    case DEAD_FIRE_CORAL;
    case DEAD_FIRE_CORAL_BLOCK;
    case DEAD_FIRE_CORAL_FAN;
    case DEAD_FIRE_CORAL_WALL_FAN;
    case DEAD_HORN_CORAL;
    case DEAD_HORN_CORAL_BLOCK;
    case DEAD_HORN_CORAL_FAN;
    case DEAD_HORN_CORAL_WALL_FAN;
    case DEAD_TUBE_CORAL;
    case DEAD_TUBE_CORAL_BLOCK;
    case DEAD_TUBE_CORAL_FAN;
    case DEAD_TUBE_CORAL_WALL_FAN;
    case DECORATED_POT;
    case DEEPSLATE;
    case DEEPSLATE_BRICK_SLAB;
    case DEEPSLATE_BRICK_STAIRS;
    case DEEPSLATE_BRICK_WALL;
    case DEEPSLATE_BRICKS;
    case DEEPSLATE_COAL_ORE;
    case DEEPSLATE_COPPER_ORE;
    case DEEPSLATE_DIAMOND_ORE;
    case DEEPSLATE_EMERALD_ORE;
    case DEEPSLATE_GOLD_ORE;
    case DEEPSLATE_IRON_ORE;
    case DEEPSLATE_LAPIS_ORE;
    case DEEPSLATE_REDSTONE_ORE;
    case DEEPSLATE_TILE_SLAB;
    case DEEPSLATE_TILE_STAIRS;
    case DEEPSLATE_TILE_WALL;
    case DEEPSLATE_TILES;
    case DETECTOR_RAIL;
    case DIAMOND_BLOCK;
    case DIAMOND_ORE;
    case DIORITE;
    case DIORITE_SLAB;
    case DIORITE_STAIRS;
    case DIORITE_WALL;
    case DIRT;
    case DIRT_PATH;
    case DISPENSER;
    case DRAGON_EGG;
    case DRAGON_HEAD;
    case DRAGON_WALL_HEAD;
    case DRIED_KELP_BLOCK;
    case DRIPSTONE_BLOCK;
    case DROPPER;
    case EMERALD_BLOCK;
    case EMERALD_ORE;
    case ENCHANTING_TABLE;
    case END_GATEWAY;
    case END_PORTAL;
    case END_PORTAL_FRAME;
    case END_ROD;
    case END_STONE;
    case END_STONE_BRICK_SLAB;
    case END_STONE_BRICK_STAIRS;
    case END_STONE_BRICK_WALL;
    case END_STONE_BRICKS;
    case ENDER_CHEST;
    case EXPOSED_CHISELED_COPPER;
    case EXPOSED_COPPER;
    case EXPOSED_COPPER_BULB;
    case EXPOSED_COPPER_DOOR;
    case EXPOSED_COPPER_GRATE;
    case EXPOSED_COPPER_TRAPDOOR;
    case EXPOSED_CUT_COPPER;
    case EXPOSED_CUT_COPPER_SLAB;
    case EXPOSED_CUT_COPPER_STAIRS;
    case FARMLAND;
    case FERN;
    case FIRE;
    case FIRE_CORAL;
    case FIRE_CORAL_BLOCK;
    case FIRE_CORAL_FAN;
    case FIRE_CORAL_WALL_FAN;
    case FIREFLY_BUSH;
    case FLETCHING_TABLE;
    case FLOWER_POT;
    case FLOWERING_AZALEA;
    case FLOWERING_AZALEA_LEAVES;
    case FROGSPAWN;
    case FROSTED_ICE;
    case FURNACE;
    case GILDED_BLACKSTONE;
    case GLASS;
    case GLASS_PANE;
    case GLOW_LICHEN;
    case GLOWSTONE;
    case GOLD_BLOCK;
    case GOLD_ORE;
    case GRANITE;
    case GRANITE_SLAB;
    case GRANITE_STAIRS;
    case GRANITE_WALL;
    case GRASS_BLOCK;
    case GRAVEL;
    case GRAY_BANNER;
    case GRAY_BED;
    case GRAY_CANDLE;
    case GRAY_CANDLE_CAKE;
    case GRAY_CARPET;
    case GRAY_CONCRETE;
    case GRAY_CONCRETE_POWDER;
    case GRAY_GLAZED_TERRACOTTA;
    case GRAY_SHULKER_BOX;
    case GRAY_STAINED_GLASS;
    case GRAY_STAINED_GLASS_PANE;
    case GRAY_TERRACOTTA;
    case GRAY_WALL_BANNER;
    case GRAY_WOOL;
    case GREEN_BANNER;
    case GREEN_BED;
    case GREEN_CANDLE;
    case GREEN_CANDLE_CAKE;
    case GREEN_CARPET;
    case GREEN_CONCRETE;
    case GREEN_CONCRETE_POWDER;
    case GREEN_GLAZED_TERRACOTTA;
    case GREEN_SHULKER_BOX;
    case GREEN_STAINED_GLASS;
    case GREEN_STAINED_GLASS_PANE;
    case GREEN_TERRACOTTA;
    case GREEN_WALL_BANNER;
    case GREEN_WOOL;
    case GRINDSTONE;
    case HANGING_ROOTS;
    case HAY_BLOCK;
    case HEAVY_CORE;
    case HEAVY_WEIGHTED_PRESSURE_PLATE;
    case HONEY_BLOCK;
    case HONEYCOMB_BLOCK;
    case HOPPER;
    case HORN_CORAL;
    case HORN_CORAL_BLOCK;
    case HORN_CORAL_FAN;
    case HORN_CORAL_WALL_FAN;
    case ICE;
    case INFESTED_CHISELED_STONE_BRICKS;
    case INFESTED_COBBLESTONE;
    case INFESTED_CRACKED_STONE_BRICKS;
    case INFESTED_DEEPSLATE;
    case INFESTED_MOSSY_STONE_BRICKS;
    case INFESTED_STONE;
    case INFESTED_STONE_BRICKS;
    case IRON_BARS;
    case IRON_BLOCK;
    case IRON_DOOR;
    case IRON_ORE;
    case IRON_TRAPDOOR;
    case JACK_O_LANTERN;
    case JIGSAW;
    case JUKEBOX;
    case JUNGLE_BUTTON;
    case JUNGLE_DOOR;
    case JUNGLE_FENCE;
    case JUNGLE_FENCE_GATE;
    case JUNGLE_HANGING_SIGN;
    case JUNGLE_LEAVES;
    case JUNGLE_LOG;
    case JUNGLE_PLANKS;
    case JUNGLE_PRESSURE_PLATE;
    case JUNGLE_SAPLING;
    case JUNGLE_SIGN;
    case JUNGLE_SLAB;
    case JUNGLE_STAIRS;
    case JUNGLE_TRAPDOOR;
    case JUNGLE_WALL_HANGING_SIGN;
    case JUNGLE_WALL_SIGN;
    case JUNGLE_WOOD;
    case KELP;
    case KELP_PLANT;
    case LADDER;
    case LANTERN;
    case LAPIS_BLOCK;
    case LAPIS_ORE;
    case LARGE_AMETHYST_BUD;
    case LARGE_FERN;
    case LAVA;
    case LAVA_CAULDRON;
    case LEAF_LITTER;
    case LECTERN;
    case LEVER;
    case LIGHT;
    case LIGHT_BLUE_BANNER;
    case LIGHT_BLUE_BED;
    case LIGHT_BLUE_CANDLE;
    case LIGHT_BLUE_CANDLE_CAKE;
    case LIGHT_BLUE_CARPET;
    case LIGHT_BLUE_CONCRETE;
    case LIGHT_BLUE_CONCRETE_POWDER;
    case LIGHT_BLUE_GLAZED_TERRACOTTA;
    case LIGHT_BLUE_SHULKER_BOX;
    case LIGHT_BLUE_STAINED_GLASS;
    case LIGHT_BLUE_STAINED_GLASS_PANE;
    case LIGHT_BLUE_TERRACOTTA;
    case LIGHT_BLUE_WALL_BANNER;
    case LIGHT_BLUE_WOOL;
    case LIGHT_GRAY_BANNER;
    case LIGHT_GRAY_BED;
    case LIGHT_GRAY_CANDLE;
    case LIGHT_GRAY_CANDLE_CAKE;
    case LIGHT_GRAY_CARPET;
    case LIGHT_GRAY_CONCRETE;
    case LIGHT_GRAY_CONCRETE_POWDER;
    case LIGHT_GRAY_GLAZED_TERRACOTTA;
    case LIGHT_GRAY_SHULKER_BOX;
    case LIGHT_GRAY_STAINED_GLASS;
    case LIGHT_GRAY_STAINED_GLASS_PANE;
    case LIGHT_GRAY_TERRACOTTA;
    case LIGHT_GRAY_WALL_BANNER;
    case LIGHT_GRAY_WOOL;
    case LIGHT_WEIGHTED_PRESSURE_PLATE;
    case LIGHTNING_ROD;
    case LILAC;
    case LILY_OF_THE_VALLEY;
    case LILY_PAD;
    case LIME_BANNER;
    case LIME_BED;
    case LIME_CANDLE;
    case LIME_CANDLE_CAKE;
    case LIME_CARPET;
    case LIME_CONCRETE;
    case LIME_CONCRETE_POWDER;
    case LIME_GLAZED_TERRACOTTA;
    case LIME_SHULKER_BOX;
    case LIME_STAINED_GLASS;
    case LIME_STAINED_GLASS_PANE;
    case LIME_TERRACOTTA;
    case LIME_WALL_BANNER;
    case LIME_WOOL;
    case LODESTONE;
    case LOOM;
    case MAGENTA_BANNER;
    case MAGENTA_BED;
    case MAGENTA_CANDLE;
    case MAGENTA_CANDLE_CAKE;
    case MAGENTA_CARPET;
    case MAGENTA_CONCRETE;
    case MAGENTA_CONCRETE_POWDER;
    case MAGENTA_GLAZED_TERRACOTTA;
    case MAGENTA_SHULKER_BOX;
    case MAGENTA_STAINED_GLASS;
    case MAGENTA_STAINED_GLASS_PANE;
    case MAGENTA_TERRACOTTA;
    case MAGENTA_WALL_BANNER;
    case MAGENTA_WOOL;
    case MAGMA_BLOCK;
    case MANGROVE_BUTTON;
    case MANGROVE_DOOR;
    case MANGROVE_FENCE;
    case MANGROVE_FENCE_GATE;
    case MANGROVE_HANGING_SIGN;
    case MANGROVE_LEAVES;
    case MANGROVE_LOG;
    case MANGROVE_PLANKS;
    case MANGROVE_PRESSURE_PLATE;
    case MANGROVE_PROPAGULE;
    case MANGROVE_ROOTS;
    case MANGROVE_SIGN;
    case MANGROVE_SLAB;
    case MANGROVE_STAIRS;
    case MANGROVE_TRAPDOOR;
    case MANGROVE_WALL_HANGING_SIGN;
    case MANGROVE_WALL_SIGN;
    case MANGROVE_WOOD;
    case MEDIUM_AMETHYST_BUD;
    case MELON;
    case MELON_STEM;
    case MOSS_BLOCK;
    case MOSS_CARPET;
    case MOSSY_COBBLESTONE;
    case MOSSY_COBBLESTONE_SLAB;
    case MOSSY_COBBLESTONE_STAIRS;
    case MOSSY_COBBLESTONE_WALL;
    case MOSSY_STONE_BRICK_SLAB;
    case MOSSY_STONE_BRICK_STAIRS;
    case MOSSY_STONE_BRICK_WALL;
    case MOSSY_STONE_BRICKS;
    case MOVING_PISTON;
    case MUD;
    case MUD_BRICK_SLAB;
    case MUD_BRICK_STAIRS;
    case MUD_BRICK_WALL;
    case MUD_BRICKS;
    case MUDDY_MANGROVE_ROOTS;
    case MUSHROOM_STEM;
    case MYCELIUM;
    case NETHER_BRICK_FENCE;
    case NETHER_BRICK_SLAB;
    case NETHER_BRICK_STAIRS;
    case NETHER_BRICK_WALL;
    case NETHER_BRICKS;
    case NETHER_GOLD_ORE;
    case NETHER_PORTAL;
    case NETHER_QUARTZ_ORE;
    case NETHER_SPROUTS;
    case NETHER_WART;
    case NETHER_WART_BLOCK;
    case NETHERITE_BLOCK;
    case NETHERRACK;
    case NOTE_BLOCK;
    case OAK_BUTTON;
    case OAK_DOOR;
    case OAK_FENCE;
    case OAK_FENCE_GATE;
    case OAK_HANGING_SIGN;
    case OAK_LEAVES;
    case OAK_LOG;
    case OAK_PLANKS;
    case OAK_PRESSURE_PLATE;
    case OAK_SAPLING;
    case OAK_SIGN;
    case OAK_SLAB;
    case OAK_STAIRS;
    case OAK_TRAPDOOR;
    case OAK_WALL_HANGING_SIGN;
    case OAK_WALL_SIGN;
    case OAK_WOOD;
    case OBSERVER;
    case OBSIDIAN;
    case OCHRE_FROGLIGHT;
    case OPEN_EYEBLOSSOM;
    case ORANGE_BANNER;
    case ORANGE_BED;
    case ORANGE_CANDLE;
    case ORANGE_CANDLE_CAKE;
    case ORANGE_CARPET;
    case ORANGE_CONCRETE;
    case ORANGE_CONCRETE_POWDER;
    case ORANGE_GLAZED_TERRACOTTA;
    case ORANGE_SHULKER_BOX;
    case ORANGE_STAINED_GLASS;
    case ORANGE_STAINED_GLASS_PANE;
    case ORANGE_TERRACOTTA;
    case ORANGE_TULIP;
    case ORANGE_WALL_BANNER;
    case ORANGE_WOOL;
    case OXEYE_DAISY;
    case OXIDIZED_CHISELED_COPPER;
    case OXIDIZED_COPPER;
    case OXIDIZED_COPPER_BULB;
    case OXIDIZED_COPPER_DOOR;
    case OXIDIZED_COPPER_GRATE;
    case OXIDIZED_COPPER_TRAPDOOR;
    case OXIDIZED_CUT_COPPER;
    case OXIDIZED_CUT_COPPER_SLAB;
    case OXIDIZED_CUT_COPPER_STAIRS;
    case PACKED_ICE;
    case PACKED_MUD;
    case PALE_HANGING_MOSS;
    case PALE_MOSS_BLOCK;
    case PALE_MOSS_CARPET;
    case PALE_OAK_BUTTON;
    case PALE_OAK_DOOR;
    case PALE_OAK_FENCE;
    case PALE_OAK_FENCE_GATE;
    case PALE_OAK_HANGING_SIGN;
    case PALE_OAK_LEAVES;
    case PALE_OAK_LOG;
    case PALE_OAK_PLANKS;
    case PALE_OAK_PRESSURE_PLATE;
    case PALE_OAK_SAPLING;
    case PALE_OAK_SIGN;
    case PALE_OAK_SLAB;
    case PALE_OAK_STAIRS;
    case PALE_OAK_TRAPDOOR;
    case PALE_OAK_WALL_HANGING_SIGN;
    case PALE_OAK_WALL_SIGN;
    case PALE_OAK_WOOD;
    case PEARLESCENT_FROGLIGHT;
    case PEONY;
    case PETRIFIED_OAK_SLAB;
    case PIGLIN_HEAD;
    case PIGLIN_WALL_HEAD;
    case PINK_BANNER;
    case PINK_BED;
    case PINK_CANDLE;
    case PINK_CANDLE_CAKE;
    case PINK_CARPET;
    case PINK_CONCRETE;
    case PINK_CONCRETE_POWDER;
    case PINK_GLAZED_TERRACOTTA;
    case PINK_PETALS;
    case PINK_SHULKER_BOX;
    case PINK_STAINED_GLASS;
    case PINK_STAINED_GLASS_PANE;
    case PINK_TERRACOTTA;
    case PINK_TULIP;
    case PINK_WALL_BANNER;
    case PINK_WOOL;
    case PISTON;
    case PISTON_HEAD;
    case PITCHER_CROP;
    case PITCHER_PLANT;
    case PLAYER_HEAD;
    case PLAYER_WALL_HEAD;
    case PODZOL;
    case POINTED_DRIPSTONE;
    case POLISHED_ANDESITE;
    case POLISHED_ANDESITE_SLAB;
    case POLISHED_ANDESITE_STAIRS;
    case POLISHED_BASALT;
    case POLISHED_BLACKSTONE;
    case POLISHED_BLACKSTONE_BRICK_SLAB;
    case POLISHED_BLACKSTONE_BRICK_STAIRS;
    case POLISHED_BLACKSTONE_BRICK_WALL;
    case POLISHED_BLACKSTONE_BRICKS;
    case POLISHED_BLACKSTONE_BUTTON;
    case POLISHED_BLACKSTONE_PRESSURE_PLATE;
    case POLISHED_BLACKSTONE_SLAB;
    case POLISHED_BLACKSTONE_STAIRS;
    case POLISHED_BLACKSTONE_WALL;
    case POLISHED_DEEPSLATE;
    case POLISHED_DEEPSLATE_SLAB;
    case POLISHED_DEEPSLATE_STAIRS;
    case POLISHED_DEEPSLATE_WALL;
    case POLISHED_DIORITE;
    case POLISHED_DIORITE_SLAB;
    case POLISHED_DIORITE_STAIRS;
    case POLISHED_GRANITE;
    case POLISHED_GRANITE_SLAB;
    case POLISHED_GRANITE_STAIRS;
    case POLISHED_TUFF;
    case POLISHED_TUFF_SLAB;
    case POLISHED_TUFF_STAIRS;
    case POLISHED_TUFF_WALL;
    case POPPY;
    case POTATOES;
    case POTTED_ACACIA_SAPLING;
    case POTTED_ALLIUM;
    case POTTED_AZALEA_BUSH;
    case POTTED_AZURE_BLUET;
    case POTTED_BAMBOO;
    case POTTED_BIRCH_SAPLING;
    case POTTED_BLUE_ORCHID;
    case POTTED_BROWN_MUSHROOM;
    case POTTED_CACTUS;
    case POTTED_CHERRY_SAPLING;
    case POTTED_CLOSED_EYEBLOSSOM;
    case POTTED_CORNFLOWER;
    case POTTED_CRIMSON_FUNGUS;
    case POTTED_CRIMSON_ROOTS;
    case POTTED_DANDELION;
    case POTTED_DARK_OAK_SAPLING;
    case POTTED_DEAD_BUSH;
    case POTTED_FERN;
    case POTTED_FLOWERING_AZALEA_BUSH;
    case POTTED_JUNGLE_SAPLING;
    case POTTED_LILY_OF_THE_VALLEY;
    case POTTED_MANGROVE_PROPAGULE;
    case POTTED_OAK_SAPLING;
    case POTTED_OPEN_EYEBLOSSOM;
    case POTTED_ORANGE_TULIP;
    case POTTED_OXEYE_DAISY;
    case POTTED_PALE_OAK_SAPLING;
    case POTTED_PINK_TULIP;
    case POTTED_POPPY;
    case POTTED_RED_MUSHROOM;
    case POTTED_RED_TULIP;
    case POTTED_SPRUCE_SAPLING;
    case POTTED_TORCHFLOWER;
    case POTTED_WARPED_FUNGUS;
    case POTTED_WARPED_ROOTS;
    case POTTED_WHITE_TULIP;
    case POTTED_WITHER_ROSE;
    case POWDER_SNOW;
    case POWDER_SNOW_CAULDRON;
    case POWERED_RAIL;
    case PRISMARINE;
    case PRISMARINE_BRICK_SLAB;
    case PRISMARINE_BRICK_STAIRS;
    case PRISMARINE_BRICKS;
    case PRISMARINE_SLAB;
    case PRISMARINE_STAIRS;
    case PRISMARINE_WALL;
    case PUMPKIN;
    case PUMPKIN_STEM;
    case PURPLE_BANNER;
    case PURPLE_BED;
    case PURPLE_CANDLE;
    case PURPLE_CANDLE_CAKE;
    case PURPLE_CARPET;
    case PURPLE_CONCRETE;
    case PURPLE_CONCRETE_POWDER;
    case PURPLE_GLAZED_TERRACOTTA;
    case PURPLE_SHULKER_BOX;
    case PURPLE_STAINED_GLASS;
    case PURPLE_STAINED_GLASS_PANE;
    case PURPLE_TERRACOTTA;
    case PURPLE_WALL_BANNER;
    case PURPLE_WOOL;
    case PURPUR_BLOCK;
    case PURPUR_PILLAR;
    case PURPUR_SLAB;
    case PURPUR_STAIRS;
    case QUARTZ_BLOCK;
    case QUARTZ_BRICKS;
    case QUARTZ_PILLAR;
    case QUARTZ_SLAB;
    case QUARTZ_STAIRS;
    case RAIL;
    case RAW_COPPER_BLOCK;
    case RAW_GOLD_BLOCK;
    case RAW_IRON_BLOCK;
    case RED_BANNER;
    case RED_BED;
    case RED_CANDLE;
    case RED_CANDLE_CAKE;
    case RED_CARPET;
    case RED_CONCRETE;
    case RED_CONCRETE_POWDER;
    case RED_GLAZED_TERRACOTTA;
    case RED_MUSHROOM;
    case RED_MUSHROOM_BLOCK;
    case RED_NETHER_BRICK_SLAB;
    case RED_NETHER_BRICK_STAIRS;
    case RED_NETHER_BRICK_WALL;
    case RED_NETHER_BRICKS;
    case RED_SAND;
    case RED_SANDSTONE;
    case RED_SANDSTONE_SLAB;
    case RED_SANDSTONE_STAIRS;
    case RED_SANDSTONE_WALL;
    case RED_SHULKER_BOX;
    case RED_STAINED_GLASS;
    case RED_STAINED_GLASS_PANE;
    case RED_TERRACOTTA;
    case RED_TULIP;
    case RED_WALL_BANNER;
    case RED_WOOL;
    case REDSTONE_BLOCK;
    case REDSTONE_LAMP;
    case REDSTONE_ORE;
    case REDSTONE_TORCH;
    case REDSTONE_WALL_TORCH;
    case REDSTONE_WIRE;
    case REINFORCED_DEEPSLATE;
    case REPEATER;
    case REPEATING_COMMAND_BLOCK;
    case RESIN_BLOCK;
    case RESIN_BRICK_SLAB;
    case RESIN_BRICK_STAIRS;
    case RESIN_BRICK_WALL;
    case RESIN_BRICKS;
    case RESIN_CLUMP;
    case RESPAWN_ANCHOR;
    case ROOTED_DIRT;
    case ROSE_BUSH;
    case SAND;
    case SANDSTONE;
    case SANDSTONE_SLAB;
    case SANDSTONE_STAIRS;
    case SANDSTONE_WALL;
    case SCAFFOLDING;
    case SCULK;
    case SCULK_CATALYST;
    case SCULK_SENSOR;
    case SCULK_SHRIEKER;
    case SCULK_VEIN;
    case SEA_LANTERN;
    case SEA_PICKLE;
    case SEAGRASS;
    case SHORT_DRY_GRASS;
    case SHORT_GRASS;
    case SHROOMLIGHT;
    case SHULKER_BOX;
    case SKELETON_SKULL;
    case SKELETON_WALL_SKULL;
    case SLIME_BLOCK;
    case SMALL_AMETHYST_BUD;
    case SMALL_DRIPLEAF;
    case SMITHING_TABLE;
    case SMOKER;
    case SMOOTH_BASALT;
    case SMOOTH_QUARTZ;
    case SMOOTH_QUARTZ_SLAB;
    case SMOOTH_QUARTZ_STAIRS;
    case SMOOTH_RED_SANDSTONE;
    case SMOOTH_RED_SANDSTONE_SLAB;
    case SMOOTH_RED_SANDSTONE_STAIRS;
    case SMOOTH_SANDSTONE;
    case SMOOTH_SANDSTONE_SLAB;
    case SMOOTH_SANDSTONE_STAIRS;
    case SMOOTH_STONE;
    case SMOOTH_STONE_SLAB;
    case SNIFFER_EGG;
    case SNOW;
    case SNOW_BLOCK;
    case SOUL_CAMPFIRE;
    case SOUL_FIRE;
    case SOUL_LANTERN;
    case SOUL_SAND;
    case SOUL_SOIL;
    case SOUL_TORCH;
    case SOUL_WALL_TORCH;
    case SPAWNER;
    case SPONGE;
    case SPORE_BLOSSOM;
    case SPRUCE_BUTTON;
    case SPRUCE_DOOR;
    case SPRUCE_FENCE;
    case SPRUCE_FENCE_GATE;
    case SPRUCE_HANGING_SIGN;
    case SPRUCE_LEAVES;
    case SPRUCE_LOG;
    case SPRUCE_PLANKS;
    case SPRUCE_PRESSURE_PLATE;
    case SPRUCE_SAPLING;
    case SPRUCE_SIGN;
    case SPRUCE_SLAB;
    case SPRUCE_STAIRS;
    case SPRUCE_TRAPDOOR;
    case SPRUCE_WALL_HANGING_SIGN;
    case SPRUCE_WALL_SIGN;
    case SPRUCE_WOOD;
    case STICKY_PISTON;
    case STONE;
    case STONE_BRICK_SLAB;
    case STONE_BRICK_STAIRS;
    case STONE_BRICK_WALL;
    case STONE_BRICKS;
    case STONE_BUTTON;
    case STONE_PRESSURE_PLATE;
    case STONE_SLAB;
    case STONE_STAIRS;
    case STONECUTTER;
    case STRIPPED_ACACIA_LOG;
    case STRIPPED_ACACIA_WOOD;
    case STRIPPED_BAMBOO_BLOCK;
    case STRIPPED_BIRCH_LOG;
    case STRIPPED_BIRCH_WOOD;
    case STRIPPED_CHERRY_LOG;
    case STRIPPED_CHERRY_WOOD;
    case STRIPPED_CRIMSON_HYPHAE;
    case STRIPPED_CRIMSON_STEM;
    case STRIPPED_DARK_OAK_LOG;
    case STRIPPED_DARK_OAK_WOOD;
    case STRIPPED_JUNGLE_LOG;
    case STRIPPED_JUNGLE_WOOD;
    case STRIPPED_MANGROVE_LOG;
    case STRIPPED_MANGROVE_WOOD;
    case STRIPPED_OAK_LOG;
    case STRIPPED_OAK_WOOD;
    case STRIPPED_PALE_OAK_LOG;
    case STRIPPED_PALE_OAK_WOOD;
    case STRIPPED_SPRUCE_LOG;
    case STRIPPED_SPRUCE_WOOD;
    case STRIPPED_WARPED_HYPHAE;
    case STRIPPED_WARPED_STEM;
    case STRUCTURE_BLOCK;
    case STRUCTURE_VOID;
    case SUGAR_CANE;
    case SUNFLOWER;
    case SUSPICIOUS_GRAVEL;
    case SUSPICIOUS_SAND;
    case SWEET_BERRY_BUSH;
    case TALL_DRY_GRASS;
    case TALL_GRASS;
    case TALL_SEAGRASS;
    case TARGET;
    case TERRACOTTA;
    case TEST_BLOCK;
    case TEST_INSTANCE_BLOCK;
    case TINTED_GLASS;
    case TNT;
    case TORCH;
    case TORCHFLOWER;
    case TORCHFLOWER_CROP;
    case TRAPPED_CHEST;
    case TRIAL_SPAWNER;
    case TRIPWIRE;
    case TRIPWIRE_HOOK;
    case TUBE_CORAL;
    case TUBE_CORAL_BLOCK;
    case TUBE_CORAL_FAN;
    case TUBE_CORAL_WALL_FAN;
    case TUFF;
    case TUFF_BRICK_SLAB;
    case TUFF_BRICK_STAIRS;
    case TUFF_BRICK_WALL;
    case TUFF_BRICKS;
    case TUFF_SLAB;
    case TUFF_STAIRS;
    case TUFF_WALL;
    case TURTLE_EGG;
    case TWISTING_VINES;
    case TWISTING_VINES_PLANT;
    case VAULT;
    case VERDANT_FROGLIGHT;
    case VINE;
    case VOID_AIR;
    case WALL_TORCH;
    case WARPED_BUTTON;
    case WARPED_DOOR;
    case WARPED_FENCE;
    case WARPED_FENCE_GATE;
    case WARPED_FUNGUS;
    case WARPED_HANGING_SIGN;
    case WARPED_HYPHAE;
    case WARPED_NYLIUM;
    case WARPED_PLANKS;
    case WARPED_PRESSURE_PLATE;
    case WARPED_ROOTS;
    case WARPED_SIGN;
    case WARPED_SLAB;
    case WARPED_STAIRS;
    case WARPED_STEM;
    case WARPED_TRAPDOOR;
    case WARPED_WALL_HANGING_SIGN;
    case WARPED_WALL_SIGN;
    case WARPED_WART_BLOCK;
    case WATER;
    case WATER_CAULDRON;
    case WAXED_CHISELED_COPPER;
    case WAXED_COPPER_BLOCK;
    case WAXED_COPPER_BULB;
    case WAXED_COPPER_DOOR;
    case WAXED_COPPER_GRATE;
    case WAXED_COPPER_TRAPDOOR;
    case WAXED_CUT_COPPER;
    case WAXED_CUT_COPPER_SLAB;
    case WAXED_CUT_COPPER_STAIRS;
    case WAXED_EXPOSED_CHISELED_COPPER;
    case WAXED_EXPOSED_COPPER;
    case WAXED_EXPOSED_COPPER_BULB;
    case WAXED_EXPOSED_COPPER_DOOR;
    case WAXED_EXPOSED_COPPER_GRATE;
    case WAXED_EXPOSED_COPPER_TRAPDOOR;
    case WAXED_EXPOSED_CUT_COPPER;
    case WAXED_EXPOSED_CUT_COPPER_SLAB;
    case WAXED_EXPOSED_CUT_COPPER_STAIRS;
    case WAXED_OXIDIZED_CHISELED_COPPER;
    case WAXED_OXIDIZED_COPPER;
    case WAXED_OXIDIZED_COPPER_BULB;
    case WAXED_OXIDIZED_COPPER_DOOR;
    case WAXED_OXIDIZED_COPPER_GRATE;
    case WAXED_OXIDIZED_COPPER_TRAPDOOR;
    case WAXED_OXIDIZED_CUT_COPPER;
    case WAXED_OXIDIZED_CUT_COPPER_SLAB;
    case WAXED_OXIDIZED_CUT_COPPER_STAIRS;
    case WAXED_WEATHERED_CHISELED_COPPER;
    case WAXED_WEATHERED_COPPER;
    case WAXED_WEATHERED_COPPER_BULB;
    case WAXED_WEATHERED_COPPER_DOOR;
    case WAXED_WEATHERED_COPPER_GRATE;
    case WAXED_WEATHERED_COPPER_TRAPDOOR;
    case WAXED_WEATHERED_CUT_COPPER;
    case WAXED_WEATHERED_CUT_COPPER_SLAB;
    case WAXED_WEATHERED_CUT_COPPER_STAIRS;
    case WEATHERED_CHISELED_COPPER;
    case WEATHERED_COPPER;
    case WEATHERED_COPPER_BULB;
    case WEATHERED_COPPER_DOOR;
    case WEATHERED_COPPER_GRATE;
    case WEATHERED_COPPER_TRAPDOOR;
    case WEATHERED_CUT_COPPER;
    case WEATHERED_CUT_COPPER_SLAB;
    case WEATHERED_CUT_COPPER_STAIRS;
    case WEEPING_VINES;
    case WEEPING_VINES_PLANT;
    case WET_SPONGE;
    case WHEAT;
    case WHITE_BANNER;
    case WHITE_BED;
    case WHITE_CANDLE;
    case WHITE_CANDLE_CAKE;
    case WHITE_CARPET;
    case WHITE_CONCRETE;
    case WHITE_CONCRETE_POWDER;
    case WHITE_GLAZED_TERRACOTTA;
    case WHITE_SHULKER_BOX;
    case WHITE_STAINED_GLASS;
    case WHITE_STAINED_GLASS_PANE;
    case WHITE_TERRACOTTA;
    case WHITE_TULIP;
    case WHITE_WALL_BANNER;
    case WHITE_WOOL;
    case WILDFLOWERS;
    case WITHER_ROSE;
    case WITHER_SKELETON_SKULL;
    case WITHER_SKELETON_WALL_SKULL;
    case YELLOW_BANNER;
    case YELLOW_BED;
    case YELLOW_CANDLE;
    case YELLOW_CANDLE_CAKE;
    case YELLOW_CARPET;
    case YELLOW_CONCRETE;
    case YELLOW_CONCRETE_POWDER;
    case YELLOW_GLAZED_TERRACOTTA;
    case YELLOW_SHULKER_BOX;
    case YELLOW_STAINED_GLASS;
    case YELLOW_STAINED_GLASS_PANE;
    case YELLOW_TERRACOTTA;
    case YELLOW_WALL_BANNER;
    case YELLOW_WOOL;
    case ZOMBIE_HEAD;
    case ZOMBIE_WALL_HEAD;

    /**
     * @template T of BlockData
     * @return class-string<T>
     */
    public function getBlockDataClass(): string
    {
        return match ($this) {
            self::STONE, self::AIR, self::ACACIA_PLANKS, self::ALLIUM, self::AMETHYST_BLOCK, self::ANCIENT_DEBRIS, self::ANDESITE, self::AZURE_BLUET, self::BAMBOO_MOSAIC, self::BAMBOO_PLANKS, self::BAMBOO_SAPLING, self::BEACON, self::BEDROCK, self::BLACK_CARPET, self::BLACK_GLAZED_TERRACOTTA, self::BLACK_CONCRETE, self::BLACK_CONCRETE_POWDER, self::BLACK_STAINED_GLASS, self::BLACK_TERRACOTTA, self::BLACK_WOOL, self::BLACKSTONE, self::BLUE_CARPET, self::BLUE_CONCRETE, self::BLUE_CONCRETE_POWDER, self::BLUE_ICE, self::BLUE_ORCHID, self::DIRT, self::DIRT_PATH, self::OAK_PLANKS, self::SHORT_GRASS, self::COBBLESTONE, self::YELLOW_CARPET, self::MOSSY_COBBLESTONE, self::POTTED_DANDELION, self::FLETCHING_TABLE, self::DANDELION, self::OXEYE_DAISY, self::POPPY, self::CORNFLOWER, self::YELLOW_WOOL, self::WHITE_WOOL => GenericBlockData::class,
            self::COMPOSTER => Composter::class,
            self::RED_BED, self::WHITE_BED => Bed::class,
            self::ACACIA_BUTTON => throw new Exception('To be implemented'),
            self::ACACIA_DOOR => throw new Exception('To be implemented'),
            self::ACACIA_FENCE, self::BAMBOO_FENCE, self::BIRCH_FENCE, self::CHERRY_FENCE, self::CRIMSON_FENCE, self::DARK_OAK_FENCE, self::JUNGLE_FENCE, self::MANGROVE_FENCE, self::NETHER_BRICK_FENCE, self::OAK_FENCE, self::PALE_OAK_FENCE, self::SPRUCE_FENCE, self::WARPED_FENCE => Fence::class,
            self::ACACIA_FENCE_GATE => throw new Exception('To be implemented'),
            self::ACACIA_HANGING_SIGN => throw new Exception('To be implemented'),
            self::ACACIA_LEAVES => throw new Exception('To be implemented'),
            self::ACACIA_LOG => throw new Exception('To be implemented'),
            self::ACACIA_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::ACACIA_SAPLING => throw new Exception('To be implemented'),
            self::ACACIA_SIGN => throw new Exception('To be implemented'),
            self::ACACIA_SLAB => throw new Exception('To be implemented'),
            self::ACACIA_STAIRS => throw new Exception('To be implemented'),
            self::ACACIA_TRAPDOOR => throw new Exception('To be implemented'),
            self::ACACIA_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::ACACIA_WALL_SIGN => throw new Exception('To be implemented'),
            self::ACACIA_WOOD => throw new Exception('To be implemented'),
            self::ACTIVATOR_RAIL => throw new Exception('To be implemented'),
            self::AMETHYST_CLUSTER => throw new Exception('To be implemented'),
            self::ANDESITE_SLAB => throw new Exception('To be implemented'),
            self::ANDESITE_STAIRS => throw new Exception('To be implemented'),
            self::ANDESITE_WALL => throw new Exception('To be implemented'),
            self::ANVIL => Anvil::class,
            self::ATTACHED_MELON_STEM => throw new Exception('To be implemented'),
            self::ATTACHED_PUMPKIN_STEM => throw new Exception('To be implemented'),
            self::AZALEA => throw new Exception('To be implemented'),
            self::AZALEA_LEAVES => throw new Exception('To be implemented'),
            self::BAMBOO => throw new Exception('To be implemented'),
            self::BAMBOO_BLOCK => throw new Exception('To be implemented'),
            self::BAMBOO_BUTTON => throw new Exception('To be implemented'),
            self::BAMBOO_DOOR => throw new Exception('To be implemented'),
            self::BAMBOO_FENCE_GATE => throw new Exception('To be implemented'),
            self::BAMBOO_HANGING_SIGN => throw new Exception('To be implemented'),
            self::BAMBOO_MOSAIC_SLAB => throw new Exception('To be implemented'),
            self::BAMBOO_MOSAIC_STAIRS => throw new Exception('To be implemented'),
            self::BAMBOO_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::BAMBOO_SIGN => throw new Exception('To be implemented'),
            self::BAMBOO_SLAB => throw new Exception('To be implemented'),
            self::BAMBOO_STAIRS => throw new Exception('To be implemented'),
            self::BAMBOO_TRAPDOOR => throw new Exception('To be implemented'),
            self::BAMBOO_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::BAMBOO_WALL_SIGN => throw new Exception('To be implemented'),
            self::BARREL => Barrel::class,
            self::BARRIER => throw new Exception('To be implemented'),
            self::BASALT => throw new Exception('To be implemented'),
            self::BEE_NEST => throw new Exception('To be implemented'),
            self::BEEHIVE => throw new Exception('To be implemented'),
            self::BEETROOTS => throw new Exception('To be implemented'),
            self::BELL => throw new Exception('To be implemented'),
            self::BIG_DRIPLEAF => throw new Exception('To be implemented'),
            self::BIG_DRIPLEAF_STEM => throw new Exception('To be implemented'),
            self::BIRCH_BUTTON => throw new Exception('To be implemented'),
            self::BIRCH_DOOR => throw new Exception('To be implemented'),
            self::BIRCH_FENCE_GATE => throw new Exception('To be implemented'),
            self::BIRCH_HANGING_SIGN => throw new Exception('To be implemented'),
            self::BIRCH_LEAVES => throw new Exception('To be implemented'),
            self::BIRCH_LOG => throw new Exception('To be implemented'),
            self::BIRCH_PLANKS => throw new Exception('To be implemented'),
            self::BIRCH_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::BIRCH_SAPLING => throw new Exception('To be implemented'),
            self::BIRCH_SIGN => throw new Exception('To be implemented'),
            self::BIRCH_SLAB => throw new Exception('To be implemented'),
            self::BIRCH_STAIRS => throw new Exception('To be implemented'),
            self::BIRCH_TRAPDOOR => throw new Exception('To be implemented'),
            self::BIRCH_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::BIRCH_WALL_SIGN => throw new Exception('To be implemented'),
            self::BIRCH_WOOD => throw new Exception('To be implemented'),
            self::BLACK_BANNER => throw new Exception('To be implemented'),
            self::BLACK_BED => throw new Exception('To be implemented'),
            self::BLACK_CANDLE => throw new Exception('To be implemented'),
            self::BLACK_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::BLACK_SHULKER_BOX => throw new Exception('To be implemented'),
            self::BLACK_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::BLACK_WALL_BANNER => throw new Exception('To be implemented'),
            self::BLACKSTONE_SLAB => throw new Exception('To be implemented'),
            self::BLACKSTONE_STAIRS => throw new Exception('To be implemented'),
            self::BLACKSTONE_WALL => throw new Exception('To be implemented'),
            self::BLAST_FURNACE => throw new Exception('To be implemented'),
            self::BLUE_BANNER => throw new Exception('To be implemented'),
            self::BLUE_BED => throw new Exception('To be implemented'),
            self::BLUE_CANDLE => throw new Exception('To be implemented'),
            self::BLUE_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::BLUE_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::BLUE_SHULKER_BOX => throw new Exception('To be implemented'),
            self::BLUE_STAINED_GLASS => throw new Exception('To be implemented'),
            self::BLUE_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::BLUE_TERRACOTTA => throw new Exception('To be implemented'),
            self::BLUE_WALL_BANNER => throw new Exception('To be implemented'),
            self::BLUE_WOOL => throw new Exception('To be implemented'),
            self::BONE_BLOCK => throw new Exception('To be implemented'),
            self::BOOKSHELF => throw new Exception('To be implemented'),
            self::BRAIN_CORAL => throw new Exception('To be implemented'),
            self::BRAIN_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::BRAIN_CORAL_FAN => throw new Exception('To be implemented'),
            self::BRAIN_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::BREWING_STAND => throw new Exception('To be implemented'),
            self::BRICK_SLAB => throw new Exception('To be implemented'),
            self::BRICK_STAIRS => throw new Exception('To be implemented'),
            self::BRICK_WALL => throw new Exception('To be implemented'),
            self::BRICKS => throw new Exception('To be implemented'),
            self::BROWN_BANNER => throw new Exception('To be implemented'),
            self::BROWN_BED => throw new Exception('To be implemented'),
            self::BROWN_CANDLE => throw new Exception('To be implemented'),
            self::BROWN_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::BROWN_CARPET => throw new Exception('To be implemented'),
            self::BROWN_CONCRETE => throw new Exception('To be implemented'),
            self::BROWN_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::BROWN_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::BROWN_MUSHROOM => throw new Exception('To be implemented'),
            self::BROWN_MUSHROOM_BLOCK => throw new Exception('To be implemented'),
            self::BROWN_SHULKER_BOX => throw new Exception('To be implemented'),
            self::BROWN_STAINED_GLASS => throw new Exception('To be implemented'),
            self::BROWN_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::BROWN_TERRACOTTA => throw new Exception('To be implemented'),
            self::BROWN_WALL_BANNER => throw new Exception('To be implemented'),
            self::BROWN_WOOL => throw new Exception('To be implemented'),
            self::BUBBLE_COLUMN => throw new Exception('To be implemented'),
            self::BUBBLE_CORAL => throw new Exception('To be implemented'),
            self::BUBBLE_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::BUBBLE_CORAL_FAN => throw new Exception('To be implemented'),
            self::BUBBLE_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::BUDDING_AMETHYST => throw new Exception('To be implemented'),
            self::BUSH => throw new Exception('To be implemented'),
            self::CACTUS => throw new Exception('To be implemented'),
            self::CACTUS_FLOWER => throw new Exception('To be implemented'),
            self::CAKE => throw new Exception('To be implemented'),
            self::CALCITE => throw new Exception('To be implemented'),
            self::CALIBRATED_SCULK_SENSOR => throw new Exception('To be implemented'),
            self::CAMPFIRE => throw new Exception('To be implemented'),
            self::CANDLE => throw new Exception('To be implemented'),
            self::CANDLE_CAKE => throw new Exception('To be implemented'),
            self::CARROTS => throw new Exception('To be implemented'),
            self::CARTOGRAPHY_TABLE => throw new Exception('To be implemented'),
            self::CARVED_PUMPKIN => throw new Exception('To be implemented'),
            self::CAULDRON => throw new Exception('To be implemented'),
            self::CAVE_AIR => throw new Exception('To be implemented'),
            self::CAVE_VINES => throw new Exception('To be implemented'),
            self::CAVE_VINES_PLANT => throw new Exception('To be implemented'),
            self::CHAIN => throw new Exception('To be implemented'),
            self::CHAIN_COMMAND_BLOCK => throw new Exception('To be implemented'),
            self::CHERRY_BUTTON => throw new Exception('To be implemented'),
            self::CHERRY_DOOR => throw new Exception('To be implemented'),
            self::CHERRY_FENCE_GATE => throw new Exception('To be implemented'),
            self::CHERRY_HANGING_SIGN => throw new Exception('To be implemented'),
            self::CHERRY_LEAVES => throw new Exception('To be implemented'),
            self::CHERRY_LOG => throw new Exception('To be implemented'),
            self::CHERRY_PLANKS => throw new Exception('To be implemented'),
            self::CHERRY_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::CHERRY_SAPLING => throw new Exception('To be implemented'),
            self::CHERRY_SIGN => throw new Exception('To be implemented'),
            self::CHERRY_SLAB => throw new Exception('To be implemented'),
            self::CHERRY_STAIRS => throw new Exception('To be implemented'),
            self::CHERRY_TRAPDOOR => throw new Exception('To be implemented'),
            self::CHERRY_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::CHERRY_WALL_SIGN => throw new Exception('To be implemented'),
            self::CHERRY_WOOD => throw new Exception('To be implemented'),
            self::CHEST => Chest::class,
            self::CHIPPED_ANVIL => throw new Exception('To be implemented'),
            self::CHISELED_BOOKSHELF => throw new Exception('To be implemented'),
            self::CHISELED_COPPER => throw new Exception('To be implemented'),
            self::CHISELED_DEEPSLATE => throw new Exception('To be implemented'),
            self::CHISELED_NETHER_BRICKS => throw new Exception('To be implemented'),
            self::CHISELED_POLISHED_BLACKSTONE => throw new Exception('To be implemented'),
            self::CHISELED_QUARTZ_BLOCK => throw new Exception('To be implemented'),
            self::CHISELED_RED_SANDSTONE => throw new Exception('To be implemented'),
            self::CHISELED_RESIN_BRICKS => throw new Exception('To be implemented'),
            self::CHISELED_SANDSTONE => throw new Exception('To be implemented'),
            self::CHISELED_STONE_BRICKS => throw new Exception('To be implemented'),
            self::CHISELED_TUFF => throw new Exception('To be implemented'),
            self::CHISELED_TUFF_BRICKS => throw new Exception('To be implemented'),
            self::CHORUS_FLOWER => throw new Exception('To be implemented'),
            self::CHORUS_PLANT => throw new Exception('To be implemented'),
            self::CLAY => throw new Exception('To be implemented'),
            self::CLOSED_EYEBLOSSOM => throw new Exception('To be implemented'),
            self::COAL_BLOCK => throw new Exception('To be implemented'),
            self::COAL_ORE => throw new Exception('To be implemented'),
            self::COARSE_DIRT => throw new Exception('To be implemented'),
            self::COBBLED_DEEPSLATE => throw new Exception('To be implemented'),
            self::COBBLED_DEEPSLATE_SLAB => throw new Exception('To be implemented'),
            self::COBBLED_DEEPSLATE_STAIRS => throw new Exception('To be implemented'),
            self::COBBLED_DEEPSLATE_WALL => throw new Exception('To be implemented'),
            self::COBBLESTONE_SLAB => throw new Exception('To be implemented'),
            self::COBBLESTONE_STAIRS => throw new Exception('To be implemented'),
            self::COBBLESTONE_WALL => throw new Exception('To be implemented'),
            self::COBWEB => throw new Exception('To be implemented'),
            self::COCOA => throw new Exception('To be implemented'),
            self::COMMAND_BLOCK => throw new Exception('To be implemented'),
            self::COMPARATOR => throw new Exception('To be implemented'),
            self::CONDUIT => throw new Exception('To be implemented'),
            self::COPPER_BLOCK => throw new Exception('To be implemented'),
            self::COPPER_BULB => throw new Exception('To be implemented'),
            self::COPPER_DOOR => throw new Exception('To be implemented'),
            self::COPPER_GRATE => throw new Exception('To be implemented'),
            self::COPPER_ORE => throw new Exception('To be implemented'),
            self::COPPER_TRAPDOOR => throw new Exception('To be implemented'),
            self::CRACKED_DEEPSLATE_BRICKS => throw new Exception('To be implemented'),
            self::CRACKED_DEEPSLATE_TILES => throw new Exception('To be implemented'),
            self::CRACKED_NETHER_BRICKS => throw new Exception('To be implemented'),
            self::CRACKED_POLISHED_BLACKSTONE_BRICKS => throw new Exception('To be implemented'),
            self::CRACKED_STONE_BRICKS => throw new Exception('To be implemented'),
            self::CRAFTER => throw new Exception('To be implemented'),
            self::CRAFTING_TABLE => throw new Exception('To be implemented'),
            self::CREAKING_HEART => throw new Exception('To be implemented'),
            self::CREEPER_HEAD => throw new Exception('To be implemented'),
            self::CREEPER_WALL_HEAD => throw new Exception('To be implemented'),
            self::CRIMSON_BUTTON => throw new Exception('To be implemented'),
            self::CRIMSON_DOOR => throw new Exception('To be implemented'),
            self::CRIMSON_FENCE_GATE => throw new Exception('To be implemented'),
            self::CRIMSON_FUNGUS => throw new Exception('To be implemented'),
            self::CRIMSON_HANGING_SIGN => throw new Exception('To be implemented'),
            self::CRIMSON_HYPHAE => throw new Exception('To be implemented'),
            self::CRIMSON_NYLIUM => throw new Exception('To be implemented'),
            self::CRIMSON_PLANKS => throw new Exception('To be implemented'),
            self::CRIMSON_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::CRIMSON_ROOTS => throw new Exception('To be implemented'),
            self::CRIMSON_SIGN => throw new Exception('To be implemented'),
            self::CRIMSON_SLAB => throw new Exception('To be implemented'),
            self::CRIMSON_STAIRS => throw new Exception('To be implemented'),
            self::CRIMSON_STEM => throw new Exception('To be implemented'),
            self::CRIMSON_TRAPDOOR => throw new Exception('To be implemented'),
            self::CRIMSON_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::CRIMSON_WALL_SIGN => throw new Exception('To be implemented'),
            self::CRYING_OBSIDIAN => throw new Exception('To be implemented'),
            self::CUT_COPPER => throw new Exception('To be implemented'),
            self::CUT_COPPER_SLAB => throw new Exception('To be implemented'),
            self::CUT_COPPER_STAIRS => throw new Exception('To be implemented'),
            self::CUT_RED_SANDSTONE => throw new Exception('To be implemented'),
            self::CUT_RED_SANDSTONE_SLAB => throw new Exception('To be implemented'),
            self::CUT_SANDSTONE => throw new Exception('To be implemented'),
            self::CUT_SANDSTONE_SLAB => throw new Exception('To be implemented'),
            self::CYAN_BANNER => throw new Exception('To be implemented'),
            self::CYAN_BED => throw new Exception('To be implemented'),
            self::CYAN_CANDLE => throw new Exception('To be implemented'),
            self::CYAN_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::CYAN_CARPET => throw new Exception('To be implemented'),
            self::CYAN_CONCRETE => throw new Exception('To be implemented'),
            self::CYAN_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::CYAN_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::CYAN_SHULKER_BOX => throw new Exception('To be implemented'),
            self::CYAN_STAINED_GLASS => throw new Exception('To be implemented'),
            self::CYAN_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::CYAN_TERRACOTTA => throw new Exception('To be implemented'),
            self::CYAN_WALL_BANNER => throw new Exception('To be implemented'),
            self::CYAN_WOOL => throw new Exception('To be implemented'),
            self::DAMAGED_ANVIL => throw new Exception('To be implemented'),
            self::DARK_OAK_BUTTON => throw new Exception('To be implemented'),
            self::DARK_OAK_DOOR => throw new Exception('To be implemented'),
            self::DARK_OAK_FENCE_GATE => throw new Exception('To be implemented'),
            self::DARK_OAK_HANGING_SIGN => throw new Exception('To be implemented'),
            self::DARK_OAK_LEAVES => throw new Exception('To be implemented'),
            self::DARK_OAK_LOG => throw new Exception('To be implemented'),
            self::DARK_OAK_PLANKS => throw new Exception('To be implemented'),
            self::DARK_OAK_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::DARK_OAK_SAPLING => throw new Exception('To be implemented'),
            self::DARK_OAK_SIGN => throw new Exception('To be implemented'),
            self::DARK_OAK_SLAB => throw new Exception('To be implemented'),
            self::DARK_OAK_STAIRS => throw new Exception('To be implemented'),
            self::DARK_OAK_TRAPDOOR => throw new Exception('To be implemented'),
            self::DARK_OAK_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::DARK_OAK_WALL_SIGN => throw new Exception('To be implemented'),
            self::DARK_OAK_WOOD => throw new Exception('To be implemented'),
            self::DARK_PRISMARINE => throw new Exception('To be implemented'),
            self::DARK_PRISMARINE_SLAB => throw new Exception('To be implemented'),
            self::DARK_PRISMARINE_STAIRS => throw new Exception('To be implemented'),
            self::DAYLIGHT_DETECTOR => throw new Exception('To be implemented'),
            self::DEAD_BRAIN_CORAL => throw new Exception('To be implemented'),
            self::DEAD_BRAIN_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::DEAD_BRAIN_CORAL_FAN => throw new Exception('To be implemented'),
            self::DEAD_BRAIN_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::DEAD_BUBBLE_CORAL => throw new Exception('To be implemented'),
            self::DEAD_BUBBLE_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::DEAD_BUBBLE_CORAL_FAN => throw new Exception('To be implemented'),
            self::DEAD_BUBBLE_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::DEAD_BUSH => throw new Exception('To be implemented'),
            self::DEAD_FIRE_CORAL => throw new Exception('To be implemented'),
            self::DEAD_FIRE_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::DEAD_FIRE_CORAL_FAN => throw new Exception('To be implemented'),
            self::DEAD_FIRE_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::DEAD_HORN_CORAL => throw new Exception('To be implemented'),
            self::DEAD_HORN_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::DEAD_HORN_CORAL_FAN => throw new Exception('To be implemented'),
            self::DEAD_HORN_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::DEAD_TUBE_CORAL => throw new Exception('To be implemented'),
            self::DEAD_TUBE_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::DEAD_TUBE_CORAL_FAN => throw new Exception('To be implemented'),
            self::DEAD_TUBE_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::DECORATED_POT => throw new Exception('To be implemented'),
            self::DEEPSLATE => throw new Exception('To be implemented'),
            self::DEEPSLATE_BRICK_SLAB => throw new Exception('To be implemented'),
            self::DEEPSLATE_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::DEEPSLATE_BRICK_WALL => throw new Exception('To be implemented'),
            self::DEEPSLATE_BRICKS => throw new Exception('To be implemented'),
            self::DEEPSLATE_COAL_ORE => throw new Exception('To be implemented'),
            self::DEEPSLATE_COPPER_ORE => throw new Exception('To be implemented'),
            self::DEEPSLATE_DIAMOND_ORE => throw new Exception('To be implemented'),
            self::DEEPSLATE_EMERALD_ORE => throw new Exception('To be implemented'),
            self::DEEPSLATE_GOLD_ORE => throw new Exception('To be implemented'),
            self::DEEPSLATE_IRON_ORE => throw new Exception('To be implemented'),
            self::DEEPSLATE_LAPIS_ORE => throw new Exception('To be implemented'),
            self::DEEPSLATE_REDSTONE_ORE => throw new Exception('To be implemented'),
            self::DEEPSLATE_TILE_SLAB => throw new Exception('To be implemented'),
            self::DEEPSLATE_TILE_STAIRS => throw new Exception('To be implemented'),
            self::DEEPSLATE_TILE_WALL => throw new Exception('To be implemented'),
            self::DEEPSLATE_TILES => throw new Exception('To be implemented'),
            self::DETECTOR_RAIL => throw new Exception('To be implemented'),
            self::DIAMOND_BLOCK => throw new Exception('To be implemented'),
            self::DIAMOND_ORE => throw new Exception('To be implemented'),
            self::DIORITE => throw new Exception('To be implemented'),
            self::DIORITE_SLAB => throw new Exception('To be implemented'),
            self::DIORITE_STAIRS => throw new Exception('To be implemented'),
            self::DIORITE_WALL => throw new Exception('To be implemented'),
            self::DISPENSER => throw new Exception('To be implemented'),
            self::DRAGON_EGG => throw new Exception('To be implemented'),
            self::DRAGON_HEAD => throw new Exception('To be implemented'),
            self::DRAGON_WALL_HEAD => throw new Exception('To be implemented'),
            self::DRIED_KELP_BLOCK => throw new Exception('To be implemented'),
            self::DRIPSTONE_BLOCK => throw new Exception('To be implemented'),
            self::DROPPER => throw new Exception('To be implemented'),
            self::EMERALD_BLOCK => throw new Exception('To be implemented'),
            self::EMERALD_ORE => throw new Exception('To be implemented'),
            self::ENCHANTING_TABLE => throw new Exception('To be implemented'),
            self::END_GATEWAY => throw new Exception('To be implemented'),
            self::END_PORTAL => throw new Exception('To be implemented'),
            self::END_PORTAL_FRAME => throw new Exception('To be implemented'),
            self::END_ROD => throw new Exception('To be implemented'),
            self::END_STONE => throw new Exception('To be implemented'),
            self::END_STONE_BRICK_SLAB => throw new Exception('To be implemented'),
            self::END_STONE_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::END_STONE_BRICK_WALL => throw new Exception('To be implemented'),
            self::END_STONE_BRICKS => throw new Exception('To be implemented'),
            self::ENDER_CHEST => throw new Exception('To be implemented'),
            self::EXPOSED_CHISELED_COPPER => throw new Exception('To be implemented'),
            self::EXPOSED_COPPER => throw new Exception('To be implemented'),
            self::EXPOSED_COPPER_BULB => throw new Exception('To be implemented'),
            self::EXPOSED_COPPER_DOOR => throw new Exception('To be implemented'),
            self::EXPOSED_COPPER_GRATE => throw new Exception('To be implemented'),
            self::EXPOSED_COPPER_TRAPDOOR => throw new Exception('To be implemented'),
            self::EXPOSED_CUT_COPPER => throw new Exception('To be implemented'),
            self::EXPOSED_CUT_COPPER_SLAB => throw new Exception('To be implemented'),
            self::EXPOSED_CUT_COPPER_STAIRS => throw new Exception('To be implemented'),
            self::FARMLAND => throw new Exception('To be implemented'),
            self::FERN => throw new Exception('To be implemented'),
            self::FIRE => throw new Exception('To be implemented'),
            self::FIRE_CORAL => throw new Exception('To be implemented'),
            self::FIRE_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::FIRE_CORAL_FAN => throw new Exception('To be implemented'),
            self::FIRE_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::FIREFLY_BUSH => throw new Exception('To be implemented'),
            self::FLOWER_POT => throw new Exception('To be implemented'),
            self::FLOWERING_AZALEA => throw new Exception('To be implemented'),
            self::FLOWERING_AZALEA_LEAVES => throw new Exception('To be implemented'),
            self::FROGSPAWN => throw new Exception('To be implemented'),
            self::FROSTED_ICE => throw new Exception('To be implemented'),
            self::FURNACE => throw new Exception('To be implemented'),
            self::GILDED_BLACKSTONE => throw new Exception('To be implemented'),
            self::GLASS => throw new Exception('To be implemented'),
            self::GLASS_PANE => GlassPane::class,
            self::GLOW_LICHEN => throw new Exception('To be implemented'),
            self::GLOWSTONE => throw new Exception('To be implemented'),
            self::GOLD_BLOCK => throw new Exception('To be implemented'),
            self::GOLD_ORE => throw new Exception('To be implemented'),
            self::GRANITE => throw new Exception('To be implemented'),
            self::GRANITE_SLAB => throw new Exception('To be implemented'),
            self::GRANITE_STAIRS => throw new Exception('To be implemented'),
            self::GRANITE_WALL => throw new Exception('To be implemented'),
            self::GRASS_BLOCK => GenericSnowy::class,
            self::GRAVEL => throw new Exception('To be implemented'),
            self::GRAY_BANNER => throw new Exception('To be implemented'),
            self::GRAY_BED => throw new Exception('To be implemented'),
            self::GRAY_CANDLE => throw new Exception('To be implemented'),
            self::GRAY_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::GRAY_CARPET => throw new Exception('To be implemented'),
            self::GRAY_CONCRETE => throw new Exception('To be implemented'),
            self::GRAY_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::GRAY_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::GRAY_SHULKER_BOX => throw new Exception('To be implemented'),
            self::GRAY_STAINED_GLASS => throw new Exception('To be implemented'),
            self::GRAY_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::GRAY_TERRACOTTA => throw new Exception('To be implemented'),
            self::GRAY_WALL_BANNER => throw new Exception('To be implemented'),
            self::GRAY_WOOL => throw new Exception('To be implemented'),
            self::GREEN_BANNER => throw new Exception('To be implemented'),
            self::GREEN_BED => throw new Exception('To be implemented'),
            self::GREEN_CANDLE => throw new Exception('To be implemented'),
            self::GREEN_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::GREEN_CARPET => throw new Exception('To be implemented'),
            self::GREEN_CONCRETE => throw new Exception('To be implemented'),
            self::GREEN_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::GREEN_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::GREEN_SHULKER_BOX => throw new Exception('To be implemented'),
            self::GREEN_STAINED_GLASS => throw new Exception('To be implemented'),
            self::GREEN_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::GREEN_TERRACOTTA => throw new Exception('To be implemented'),
            self::GREEN_WALL_BANNER => throw new Exception('To be implemented'),
            self::GREEN_WOOL => throw new Exception('To be implemented'),
            self::GRINDSTONE => throw new Exception('To be implemented'),
            self::HANGING_ROOTS => throw new Exception('To be implemented'),
            self::HAY_BLOCK => throw new Exception('To be implemented'),
            self::HEAVY_CORE => throw new Exception('To be implemented'),
            self::HEAVY_WEIGHTED_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::HONEY_BLOCK => throw new Exception('To be implemented'),
            self::HONEYCOMB_BLOCK => throw new Exception('To be implemented'),
            self::HOPPER => throw new Exception('To be implemented'),
            self::HORN_CORAL => throw new Exception('To be implemented'),
            self::HORN_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::HORN_CORAL_FAN => throw new Exception('To be implemented'),
            self::HORN_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::ICE => throw new Exception('To be implemented'),
            self::INFESTED_CHISELED_STONE_BRICKS => throw new Exception('To be implemented'),
            self::INFESTED_COBBLESTONE => throw new Exception('To be implemented'),
            self::INFESTED_CRACKED_STONE_BRICKS => throw new Exception('To be implemented'),
            self::INFESTED_DEEPSLATE => throw new Exception('To be implemented'),
            self::INFESTED_MOSSY_STONE_BRICKS => throw new Exception('To be implemented'),
            self::INFESTED_STONE => throw new Exception('To be implemented'),
            self::INFESTED_STONE_BRICKS => throw new Exception('To be implemented'),
            self::IRON_BARS => throw new Exception('To be implemented'),
            self::IRON_BLOCK => throw new Exception('To be implemented'),
            self::IRON_DOOR => throw new Exception('To be implemented'),
            self::IRON_ORE => throw new Exception('To be implemented'),
            self::IRON_TRAPDOOR => throw new Exception('To be implemented'),
            self::JACK_O_LANTERN => throw new Exception('To be implemented'),
            self::JIGSAW => throw new Exception('To be implemented'),
            self::JUKEBOX => throw new Exception('To be implemented'),
            self::JUNGLE_BUTTON => throw new Exception('To be implemented'),
            self::JUNGLE_DOOR => throw new Exception('To be implemented'),
            self::JUNGLE_FENCE_GATE => throw new Exception('To be implemented'),
            self::JUNGLE_HANGING_SIGN => throw new Exception('To be implemented'),
            self::JUNGLE_LEAVES => throw new Exception('To be implemented'),
            self::JUNGLE_LOG => throw new Exception('To be implemented'),
            self::JUNGLE_PLANKS => throw new Exception('To be implemented'),
            self::JUNGLE_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::JUNGLE_SAPLING => throw new Exception('To be implemented'),
            self::JUNGLE_SIGN => throw new Exception('To be implemented'),
            self::JUNGLE_SLAB => throw new Exception('To be implemented'),
            self::JUNGLE_STAIRS => throw new Exception('To be implemented'),
            self::JUNGLE_TRAPDOOR => throw new Exception('To be implemented'),
            self::JUNGLE_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::JUNGLE_WALL_SIGN => throw new Exception('To be implemented'),
            self::JUNGLE_WOOD => throw new Exception('To be implemented'),
            self::KELP => throw new Exception('To be implemented'),
            self::KELP_PLANT => throw new Exception('To be implemented'),
            self::LADDER => throw new Exception('To be implemented'),
            self::LANTERN => throw new Exception('To be implemented'),
            self::LAPIS_BLOCK => throw new Exception('To be implemented'),
            self::LAPIS_ORE => throw new Exception('To be implemented'),
            self::LARGE_AMETHYST_BUD => throw new Exception('To be implemented'),
            self::LARGE_FERN => throw new Exception('To be implemented'),
            self::LAVA => throw new Exception('To be implemented'),
            self::LAVA_CAULDRON => throw new Exception('To be implemented'),
            self::LEAF_LITTER => throw new Exception('To be implemented'),
            self::LECTERN => throw new Exception('To be implemented'),
            self::LEVER => throw new Exception('To be implemented'),
            self::LIGHT => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_BANNER => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_BED => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_CANDLE => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_CARPET => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_CONCRETE => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_SHULKER_BOX => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_STAINED_GLASS => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_TERRACOTTA => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_WALL_BANNER => throw new Exception('To be implemented'),
            self::LIGHT_BLUE_WOOL => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_BANNER => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_BED => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_CANDLE => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_CARPET => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_CONCRETE => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_SHULKER_BOX => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_STAINED_GLASS => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_TERRACOTTA => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_WALL_BANNER => throw new Exception('To be implemented'),
            self::LIGHT_GRAY_WOOL => throw new Exception('To be implemented'),
            self::LIGHT_WEIGHTED_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::LIGHTNING_ROD => throw new Exception('To be implemented'),
            self::LILAC => throw new Exception('To be implemented'),
            self::LILY_OF_THE_VALLEY => throw new Exception('To be implemented'),
            self::LILY_PAD => throw new Exception('To be implemented'),
            self::LIME_BANNER => throw new Exception('To be implemented'),
            self::LIME_BED => throw new Exception('To be implemented'),
            self::LIME_CANDLE => throw new Exception('To be implemented'),
            self::LIME_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::LIME_CARPET => throw new Exception('To be implemented'),
            self::LIME_CONCRETE => throw new Exception('To be implemented'),
            self::LIME_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::LIME_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::LIME_SHULKER_BOX => throw new Exception('To be implemented'),
            self::LIME_STAINED_GLASS => throw new Exception('To be implemented'),
            self::LIME_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::LIME_TERRACOTTA => throw new Exception('To be implemented'),
            self::LIME_WALL_BANNER => throw new Exception('To be implemented'),
            self::LIME_WOOL => throw new Exception('To be implemented'),
            self::LODESTONE => throw new Exception('To be implemented'),
            self::LOOM => throw new Exception('To be implemented'),
            self::MAGENTA_BANNER => throw new Exception('To be implemented'),
            self::MAGENTA_BED => throw new Exception('To be implemented'),
            self::MAGENTA_CANDLE => throw new Exception('To be implemented'),
            self::MAGENTA_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::MAGENTA_CARPET => throw new Exception('To be implemented'),
            self::MAGENTA_CONCRETE => throw new Exception('To be implemented'),
            self::MAGENTA_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::MAGENTA_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::MAGENTA_SHULKER_BOX => throw new Exception('To be implemented'),
            self::MAGENTA_STAINED_GLASS => throw new Exception('To be implemented'),
            self::MAGENTA_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::MAGENTA_TERRACOTTA => throw new Exception('To be implemented'),
            self::MAGENTA_WALL_BANNER => throw new Exception('To be implemented'),
            self::MAGENTA_WOOL => throw new Exception('To be implemented'),
            self::MAGMA_BLOCK => throw new Exception('To be implemented'),
            self::MANGROVE_BUTTON => throw new Exception('To be implemented'),
            self::MANGROVE_DOOR => throw new Exception('To be implemented'),
            self::MANGROVE_FENCE_GATE => throw new Exception('To be implemented'),
            self::MANGROVE_HANGING_SIGN => throw new Exception('To be implemented'),
            self::MANGROVE_LEAVES => throw new Exception('To be implemented'),
            self::MANGROVE_LOG => throw new Exception('To be implemented'),
            self::MANGROVE_PLANKS => throw new Exception('To be implemented'),
            self::MANGROVE_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::MANGROVE_PROPAGULE => throw new Exception('To be implemented'),
            self::MANGROVE_ROOTS => throw new Exception('To be implemented'),
            self::MANGROVE_SIGN => throw new Exception('To be implemented'),
            self::MANGROVE_SLAB => throw new Exception('To be implemented'),
            self::MANGROVE_STAIRS => throw new Exception('To be implemented'),
            self::MANGROVE_TRAPDOOR => throw new Exception('To be implemented'),
            self::MANGROVE_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::MANGROVE_WALL_SIGN => throw new Exception('To be implemented'),
            self::MANGROVE_WOOD => throw new Exception('To be implemented'),
            self::MEDIUM_AMETHYST_BUD => throw new Exception('To be implemented'),
            self::MELON => throw new Exception('To be implemented'),
            self::MELON_STEM => throw new Exception('To be implemented'),
            self::MOSS_BLOCK => throw new Exception('To be implemented'),
            self::MOSS_CARPET => throw new Exception('To be implemented'),
            self::MOSSY_COBBLESTONE_SLAB => throw new Exception('To be implemented'),
            self::MOSSY_COBBLESTONE_STAIRS => throw new Exception('To be implemented'),
            self::MOSSY_COBBLESTONE_WALL => throw new Exception('To be implemented'),
            self::MOSSY_STONE_BRICK_SLAB => throw new Exception('To be implemented'),
            self::MOSSY_STONE_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::MOSSY_STONE_BRICK_WALL => throw new Exception('To be implemented'),
            self::MOSSY_STONE_BRICKS => throw new Exception('To be implemented'),
            self::MOVING_PISTON => throw new Exception('To be implemented'),
            self::MUD => throw new Exception('To be implemented'),
            self::MUD_BRICK_SLAB => throw new Exception('To be implemented'),
            self::MUD_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::MUD_BRICK_WALL => throw new Exception('To be implemented'),
            self::MUD_BRICKS => throw new Exception('To be implemented'),
            self::MUDDY_MANGROVE_ROOTS => throw new Exception('To be implemented'),
            self::MUSHROOM_STEM => throw new Exception('To be implemented'),
            self::MYCELIUM => throw new Exception('To be implemented'),
            self::NETHER_BRICK_SLAB => throw new Exception('To be implemented'),
            self::NETHER_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::NETHER_BRICK_WALL => throw new Exception('To be implemented'),
            self::NETHER_BRICKS => throw new Exception('To be implemented'),
            self::NETHER_GOLD_ORE => throw new Exception('To be implemented'),
            self::NETHER_PORTAL => throw new Exception('To be implemented'),
            self::NETHER_QUARTZ_ORE => throw new Exception('To be implemented'),
            self::NETHER_SPROUTS => throw new Exception('To be implemented'),
            self::NETHER_WART => throw new Exception('To be implemented'),
            self::NETHER_WART_BLOCK => throw new Exception('To be implemented'),
            self::NETHERITE_BLOCK => throw new Exception('To be implemented'),
            self::NETHERRACK => throw new Exception('To be implemented'),
            self::NOTE_BLOCK => throw new Exception('To be implemented'),
            self::OAK_BUTTON => throw new Exception('To be implemented'),
            self::OAK_DOOR => Door::class,
            self::OAK_FENCE_GATE => throw new Exception('To be implemented'),
            self::OAK_HANGING_SIGN => throw new Exception('To be implemented'),
            self::OAK_LEAVES => throw new Exception('To be implemented'),
            self::OAK_LOG, self::STRIPPED_OAK_WOOD, self::STRIPPED_OAK_LOG => GenericOrientable::class,
            self::OAK_PRESSURE_PLATE => GenericBlockData::class, // TODO: implement real logic
            self::OAK_SAPLING => throw new Exception('To be implemented'),
            self::OAK_SIGN => Sign::class,
            self::OAK_SLAB => Slab::class,
            self::OAK_STAIRS => Stairs::class,
            self::OAK_TRAPDOOR => throw new Exception('To be implemented'),
            self::OAK_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::OAK_WALL_SIGN => throw new Exception('To be implemented'),
            self::OAK_WOOD => throw new Exception('To be implemented'),
            self::OBSERVER => throw new Exception('To be implemented'),
            self::OBSIDIAN => throw new Exception('To be implemented'),
            self::OCHRE_FROGLIGHT => throw new Exception('To be implemented'),
            self::OPEN_EYEBLOSSOM => throw new Exception('To be implemented'),
            self::ORANGE_BANNER => throw new Exception('To be implemented'),
            self::ORANGE_BED => throw new Exception('To be implemented'),
            self::ORANGE_CANDLE => throw new Exception('To be implemented'),
            self::ORANGE_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::ORANGE_CARPET => throw new Exception('To be implemented'),
            self::ORANGE_CONCRETE => throw new Exception('To be implemented'),
            self::ORANGE_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::ORANGE_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::ORANGE_SHULKER_BOX => throw new Exception('To be implemented'),
            self::ORANGE_STAINED_GLASS => throw new Exception('To be implemented'),
            self::ORANGE_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::ORANGE_TERRACOTTA => throw new Exception('To be implemented'),
            self::ORANGE_TULIP => throw new Exception('To be implemented'),
            self::ORANGE_WALL_BANNER => throw new Exception('To be implemented'),
            self::ORANGE_WOOL => throw new Exception('To be implemented'),
            self::OXIDIZED_CHISELED_COPPER => throw new Exception('To be implemented'),
            self::OXIDIZED_COPPER => throw new Exception('To be implemented'),
            self::OXIDIZED_COPPER_BULB => throw new Exception('To be implemented'),
            self::OXIDIZED_COPPER_DOOR => throw new Exception('To be implemented'),
            self::OXIDIZED_COPPER_GRATE => throw new Exception('To be implemented'),
            self::OXIDIZED_COPPER_TRAPDOOR => throw new Exception('To be implemented'),
            self::OXIDIZED_CUT_COPPER => throw new Exception('To be implemented'),
            self::OXIDIZED_CUT_COPPER_SLAB => throw new Exception('To be implemented'),
            self::OXIDIZED_CUT_COPPER_STAIRS => throw new Exception('To be implemented'),
            self::PACKED_ICE => throw new Exception('To be implemented'),
            self::PACKED_MUD => throw new Exception('To be implemented'),
            self::PALE_HANGING_MOSS => throw new Exception('To be implemented'),
            self::PALE_MOSS_BLOCK => throw new Exception('To be implemented'),
            self::PALE_MOSS_CARPET => throw new Exception('To be implemented'),
            self::PALE_OAK_BUTTON => throw new Exception('To be implemented'),
            self::PALE_OAK_DOOR => throw new Exception('To be implemented'),
            self::PALE_OAK_FENCE_GATE => throw new Exception('To be implemented'),
            self::PALE_OAK_HANGING_SIGN => throw new Exception('To be implemented'),
            self::PALE_OAK_LEAVES => throw new Exception('To be implemented'),
            self::PALE_OAK_LOG => throw new Exception('To be implemented'),
            self::PALE_OAK_PLANKS => throw new Exception('To be implemented'),
            self::PALE_OAK_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::PALE_OAK_SAPLING => throw new Exception('To be implemented'),
            self::PALE_OAK_SIGN => throw new Exception('To be implemented'),
            self::PALE_OAK_SLAB => throw new Exception('To be implemented'),
            self::PALE_OAK_STAIRS => throw new Exception('To be implemented'),
            self::PALE_OAK_TRAPDOOR => throw new Exception('To be implemented'),
            self::PALE_OAK_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::PALE_OAK_WALL_SIGN => throw new Exception('To be implemented'),
            self::PALE_OAK_WOOD => throw new Exception('To be implemented'),
            self::PEARLESCENT_FROGLIGHT => throw new Exception('To be implemented'),
            self::PEONY => throw new Exception('To be implemented'),
            self::PETRIFIED_OAK_SLAB => throw new Exception('To be implemented'),
            self::PIGLIN_HEAD => throw new Exception('To be implemented'),
            self::PIGLIN_WALL_HEAD => throw new Exception('To be implemented'),
            self::PINK_BANNER => throw new Exception('To be implemented'),
            self::PINK_BED => throw new Exception('To be implemented'),
            self::PINK_CANDLE => throw new Exception('To be implemented'),
            self::PINK_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::PINK_CARPET => throw new Exception('To be implemented'),
            self::PINK_CONCRETE => throw new Exception('To be implemented'),
            self::PINK_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::PINK_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::PINK_PETALS => throw new Exception('To be implemented'),
            self::PINK_SHULKER_BOX => throw new Exception('To be implemented'),
            self::PINK_STAINED_GLASS => throw new Exception('To be implemented'),
            self::PINK_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::PINK_TERRACOTTA => throw new Exception('To be implemented'),
            self::PINK_TULIP => throw new Exception('To be implemented'),
            self::PINK_WALL_BANNER => throw new Exception('To be implemented'),
            self::PINK_WOOL => throw new Exception('To be implemented'),
            self::PISTON => throw new Exception('To be implemented'),
            self::PISTON_HEAD => throw new Exception('To be implemented'),
            self::PITCHER_CROP => throw new Exception('To be implemented'),
            self::PITCHER_PLANT => throw new Exception('To be implemented'),
            self::PLAYER_HEAD => throw new Exception('To be implemented'),
            self::PLAYER_WALL_HEAD => throw new Exception('To be implemented'),
            self::PODZOL => throw new Exception('To be implemented'),
            self::POINTED_DRIPSTONE => throw new Exception('To be implemented'),
            self::POLISHED_ANDESITE => throw new Exception('To be implemented'),
            self::POLISHED_ANDESITE_SLAB => throw new Exception('To be implemented'),
            self::POLISHED_ANDESITE_STAIRS => throw new Exception('To be implemented'),
            self::POLISHED_BASALT => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE_BRICK_SLAB => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE_BRICK_WALL => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE_BRICKS => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE_BUTTON => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE_SLAB => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE_STAIRS => throw new Exception('To be implemented'),
            self::POLISHED_BLACKSTONE_WALL => throw new Exception('To be implemented'),
            self::POLISHED_DEEPSLATE => throw new Exception('To be implemented'),
            self::POLISHED_DEEPSLATE_SLAB => throw new Exception('To be implemented'),
            self::POLISHED_DEEPSLATE_STAIRS => throw new Exception('To be implemented'),
            self::POLISHED_DEEPSLATE_WALL => throw new Exception('To be implemented'),
            self::POLISHED_DIORITE => throw new Exception('To be implemented'),
            self::POLISHED_DIORITE_SLAB => throw new Exception('To be implemented'),
            self::POLISHED_DIORITE_STAIRS => throw new Exception('To be implemented'),
            self::POLISHED_GRANITE => throw new Exception('To be implemented'),
            self::POLISHED_GRANITE_SLAB => throw new Exception('To be implemented'),
            self::POLISHED_GRANITE_STAIRS => throw new Exception('To be implemented'),
            self::POLISHED_TUFF => throw new Exception('To be implemented'),
            self::POLISHED_TUFF_SLAB => throw new Exception('To be implemented'),
            self::POLISHED_TUFF_STAIRS => throw new Exception('To be implemented'),
            self::POLISHED_TUFF_WALL => throw new Exception('To be implemented'),
            self::POTATOES => throw new Exception('To be implemented'),
            self::POTTED_ACACIA_SAPLING => throw new Exception('To be implemented'),
            self::POTTED_ALLIUM => throw new Exception('To be implemented'),
            self::POTTED_AZALEA_BUSH => throw new Exception('To be implemented'),
            self::POTTED_AZURE_BLUET => throw new Exception('To be implemented'),
            self::POTTED_BAMBOO => throw new Exception('To be implemented'),
            self::POTTED_BIRCH_SAPLING => throw new Exception('To be implemented'),
            self::POTTED_BLUE_ORCHID => throw new Exception('To be implemented'),
            self::POTTED_BROWN_MUSHROOM => throw new Exception('To be implemented'),
            self::POTTED_CACTUS => throw new Exception('To be implemented'),
            self::POTTED_CHERRY_SAPLING => throw new Exception('To be implemented'),
            self::POTTED_CLOSED_EYEBLOSSOM => throw new Exception('To be implemented'),
            self::POTTED_CORNFLOWER => throw new Exception('To be implemented'),
            self::POTTED_CRIMSON_FUNGUS => throw new Exception('To be implemented'),
            self::POTTED_CRIMSON_ROOTS => throw new Exception('To be implemented'),
            self::POTTED_DARK_OAK_SAPLING => throw new Exception('To be implemented'),
            self::POTTED_DEAD_BUSH => throw new Exception('To be implemented'),
            self::POTTED_FERN => throw new Exception('To be implemented'),
            self::POTTED_FLOWERING_AZALEA_BUSH => throw new Exception('To be implemented'),
            self::POTTED_JUNGLE_SAPLING => throw new Exception('To be implemented'),
            self::POTTED_LILY_OF_THE_VALLEY => throw new Exception('To be implemented'),
            self::POTTED_MANGROVE_PROPAGULE => throw new Exception('To be implemented'),
            self::POTTED_OAK_SAPLING => throw new Exception('To be implemented'),
            self::POTTED_OPEN_EYEBLOSSOM => throw new Exception('To be implemented'),
            self::POTTED_ORANGE_TULIP => throw new Exception('To be implemented'),
            self::POTTED_OXEYE_DAISY => throw new Exception('To be implemented'),
            self::POTTED_PALE_OAK_SAPLING => throw new Exception('To be implemented'),
            self::POTTED_PINK_TULIP => throw new Exception('To be implemented'),
            self::POTTED_POPPY => throw new Exception('To be implemented'),
            self::POTTED_RED_MUSHROOM => throw new Exception('To be implemented'),
            self::POTTED_RED_TULIP => throw new Exception('To be implemented'),
            self::POTTED_SPRUCE_SAPLING => throw new Exception('To be implemented'),
            self::POTTED_TORCHFLOWER => throw new Exception('To be implemented'),
            self::POTTED_WARPED_FUNGUS => throw new Exception('To be implemented'),
            self::POTTED_WARPED_ROOTS => throw new Exception('To be implemented'),
            self::POTTED_WHITE_TULIP => throw new Exception('To be implemented'),
            self::POTTED_WITHER_ROSE => throw new Exception('To be implemented'),
            self::POWDER_SNOW => throw new Exception('To be implemented'),
            self::POWDER_SNOW_CAULDRON => throw new Exception('To be implemented'),
            self::POWERED_RAIL => throw new Exception('To be implemented'),
            self::PRISMARINE => throw new Exception('To be implemented'),
            self::PRISMARINE_BRICK_SLAB => throw new Exception('To be implemented'),
            self::PRISMARINE_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::PRISMARINE_BRICKS => throw new Exception('To be implemented'),
            self::PRISMARINE_SLAB => throw new Exception('To be implemented'),
            self::PRISMARINE_STAIRS => throw new Exception('To be implemented'),
            self::PRISMARINE_WALL => throw new Exception('To be implemented'),
            self::PUMPKIN => throw new Exception('To be implemented'),
            self::PUMPKIN_STEM => throw new Exception('To be implemented'),
            self::PURPLE_BANNER => throw new Exception('To be implemented'),
            self::PURPLE_BED => throw new Exception('To be implemented'),
            self::PURPLE_CANDLE => throw new Exception('To be implemented'),
            self::PURPLE_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::PURPLE_CARPET => throw new Exception('To be implemented'),
            self::PURPLE_CONCRETE => throw new Exception('To be implemented'),
            self::PURPLE_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::PURPLE_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::PURPLE_SHULKER_BOX => throw new Exception('To be implemented'),
            self::PURPLE_STAINED_GLASS => throw new Exception('To be implemented'),
            self::PURPLE_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::PURPLE_TERRACOTTA => throw new Exception('To be implemented'),
            self::PURPLE_WALL_BANNER => throw new Exception('To be implemented'),
            self::PURPLE_WOOL => throw new Exception('To be implemented'),
            self::PURPUR_BLOCK => throw new Exception('To be implemented'),
            self::PURPUR_PILLAR => throw new Exception('To be implemented'),
            self::PURPUR_SLAB => throw new Exception('To be implemented'),
            self::PURPUR_STAIRS => throw new Exception('To be implemented'),
            self::QUARTZ_BLOCK => throw new Exception('To be implemented'),
            self::QUARTZ_BRICKS => throw new Exception('To be implemented'),
            self::QUARTZ_PILLAR => throw new Exception('To be implemented'),
            self::QUARTZ_SLAB => throw new Exception('To be implemented'),
            self::QUARTZ_STAIRS => throw new Exception('To be implemented'),
            self::RAIL => throw new Exception('To be implemented'),
            self::RAW_COPPER_BLOCK => throw new Exception('To be implemented'),
            self::RAW_GOLD_BLOCK => throw new Exception('To be implemented'),
            self::RAW_IRON_BLOCK => throw new Exception('To be implemented'),
            self::RED_BANNER => throw new Exception('To be implemented'),
            self::RED_CANDLE => throw new Exception('To be implemented'),
            self::RED_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::RED_CARPET => throw new Exception('To be implemented'),
            self::RED_CONCRETE => throw new Exception('To be implemented'),
            self::RED_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::RED_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::RED_MUSHROOM => throw new Exception('To be implemented'),
            self::RED_MUSHROOM_BLOCK => throw new Exception('To be implemented'),
            self::RED_NETHER_BRICK_SLAB => throw new Exception('To be implemented'),
            self::RED_NETHER_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::RED_NETHER_BRICK_WALL => throw new Exception('To be implemented'),
            self::RED_NETHER_BRICKS => throw new Exception('To be implemented'),
            self::RED_SAND => throw new Exception('To be implemented'),
            self::RED_SANDSTONE => throw new Exception('To be implemented'),
            self::RED_SANDSTONE_SLAB => throw new Exception('To be implemented'),
            self::RED_SANDSTONE_STAIRS => throw new Exception('To be implemented'),
            self::RED_SANDSTONE_WALL => throw new Exception('To be implemented'),
            self::RED_SHULKER_BOX => throw new Exception('To be implemented'),
            self::RED_STAINED_GLASS => throw new Exception('To be implemented'),
            self::RED_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::RED_TERRACOTTA => throw new Exception('To be implemented'),
            self::RED_TULIP => throw new Exception('To be implemented'),
            self::RED_WALL_BANNER => throw new Exception('To be implemented'),
            self::RED_WOOL => throw new Exception('To be implemented'),
            self::REDSTONE_BLOCK => throw new Exception('To be implemented'),
            self::REDSTONE_LAMP => throw new Exception('To be implemented'),
            self::REDSTONE_ORE => throw new Exception('To be implemented'),
            self::REDSTONE_TORCH => throw new Exception('To be implemented'),
            self::REDSTONE_WALL_TORCH => throw new Exception('To be implemented'),
            self::REDSTONE_WIRE => throw new Exception('To be implemented'),
            self::REINFORCED_DEEPSLATE => throw new Exception('To be implemented'),
            self::REPEATER => throw new Exception('To be implemented'),
            self::REPEATING_COMMAND_BLOCK => throw new Exception('To be implemented'),
            self::RESIN_BLOCK => throw new Exception('To be implemented'),
            self::RESIN_BRICK_SLAB => throw new Exception('To be implemented'),
            self::RESIN_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::RESIN_BRICK_WALL => throw new Exception('To be implemented'),
            self::RESIN_BRICKS => throw new Exception('To be implemented'),
            self::RESIN_CLUMP => throw new Exception('To be implemented'),
            self::RESPAWN_ANCHOR => throw new Exception('To be implemented'),
            self::ROOTED_DIRT => throw new Exception('To be implemented'),
            self::ROSE_BUSH => throw new Exception('To be implemented'),
            self::SAND => throw new Exception('To be implemented'),
            self::SANDSTONE => throw new Exception('To be implemented'),
            self::SANDSTONE_SLAB => throw new Exception('To be implemented'),
            self::SANDSTONE_STAIRS => throw new Exception('To be implemented'),
            self::SANDSTONE_WALL => throw new Exception('To be implemented'),
            self::SCAFFOLDING => throw new Exception('To be implemented'),
            self::SCULK => throw new Exception('To be implemented'),
            self::SCULK_CATALYST => throw new Exception('To be implemented'),
            self::SCULK_SENSOR => throw new Exception('To be implemented'),
            self::SCULK_SHRIEKER => throw new Exception('To be implemented'),
            self::SCULK_VEIN => throw new Exception('To be implemented'),
            self::SEA_LANTERN => throw new Exception('To be implemented'),
            self::SEA_PICKLE => throw new Exception('To be implemented'),
            self::SEAGRASS => throw new Exception('To be implemented'),
            self::SHORT_DRY_GRASS => throw new Exception('To be implemented'),
            self::SHROOMLIGHT => throw new Exception('To be implemented'),
            self::SHULKER_BOX => throw new Exception('To be implemented'),
            self::SKELETON_SKULL => throw new Exception('To be implemented'),
            self::SKELETON_WALL_SKULL => throw new Exception('To be implemented'),
            self::SLIME_BLOCK => throw new Exception('To be implemented'),
            self::SMALL_AMETHYST_BUD => throw new Exception('To be implemented'),
            self::SMALL_DRIPLEAF => throw new Exception('To be implemented'),
            self::SMITHING_TABLE => throw new Exception('To be implemented'),
            self::SMOKER => throw new Exception('To be implemented'),
            self::SMOOTH_BASALT => throw new Exception('To be implemented'),
            self::SMOOTH_QUARTZ => throw new Exception('To be implemented'),
            self::SMOOTH_QUARTZ_SLAB => throw new Exception('To be implemented'),
            self::SMOOTH_QUARTZ_STAIRS => throw new Exception('To be implemented'),
            self::SMOOTH_RED_SANDSTONE => throw new Exception('To be implemented'),
            self::SMOOTH_RED_SANDSTONE_SLAB => throw new Exception('To be implemented'),
            self::SMOOTH_RED_SANDSTONE_STAIRS => throw new Exception('To be implemented'),
            self::SMOOTH_SANDSTONE => throw new Exception('To be implemented'),
            self::SMOOTH_SANDSTONE_SLAB => throw new Exception('To be implemented'),
            self::SMOOTH_SANDSTONE_STAIRS => throw new Exception('To be implemented'),
            self::SMOOTH_STONE => throw new Exception('To be implemented'),
            self::SMOOTH_STONE_SLAB => throw new Exception('To be implemented'),
            self::SNIFFER_EGG => throw new Exception('To be implemented'),
            self::SNOW => throw new Exception('To be implemented'),
            self::SNOW_BLOCK => throw new Exception('To be implemented'),
            self::SOUL_CAMPFIRE => throw new Exception('To be implemented'),
            self::SOUL_FIRE => throw new Exception('To be implemented'),
            self::SOUL_LANTERN => throw new Exception('To be implemented'),
            self::SOUL_SAND => throw new Exception('To be implemented'),
            self::SOUL_SOIL => throw new Exception('To be implemented'),
            self::SOUL_TORCH => throw new Exception('To be implemented'),
            self::SOUL_WALL_TORCH => throw new Exception('To be implemented'),
            self::SPAWNER => throw new Exception('To be implemented'),
            self::SPONGE => throw new Exception('To be implemented'),
            self::SPORE_BLOSSOM => throw new Exception('To be implemented'),
            self::SPRUCE_BUTTON => throw new Exception('To be implemented'),
            self::SPRUCE_DOOR => throw new Exception('To be implemented'),
            self::SPRUCE_FENCE_GATE => throw new Exception('To be implemented'),
            self::SPRUCE_HANGING_SIGN => throw new Exception('To be implemented'),
            self::SPRUCE_LEAVES => throw new Exception('To be implemented'),
            self::SPRUCE_LOG => throw new Exception('To be implemented'),
            self::SPRUCE_PLANKS => throw new Exception('To be implemented'),
            self::SPRUCE_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::SPRUCE_SAPLING => throw new Exception('To be implemented'),
            self::SPRUCE_SIGN => throw new Exception('To be implemented'),
            self::SPRUCE_SLAB => throw new Exception('To be implemented'),
            self::SPRUCE_STAIRS => throw new Exception('To be implemented'),
            self::SPRUCE_TRAPDOOR => throw new Exception('To be implemented'),
            self::SPRUCE_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::SPRUCE_WALL_SIGN => throw new Exception('To be implemented'),
            self::SPRUCE_WOOD => throw new Exception('To be implemented'),
            self::STICKY_PISTON => throw new Exception('To be implemented'),
            self::STONE_BRICK_SLAB => throw new Exception('To be implemented'),
            self::STONE_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::STONE_BRICK_WALL => throw new Exception('To be implemented'),
            self::STONE_BRICKS => throw new Exception('To be implemented'),
            self::STONE_BUTTON => throw new Exception('To be implemented'),
            self::STONE_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::STONE_SLAB => throw new Exception('To be implemented'),
            self::STONE_STAIRS => throw new Exception('To be implemented'),
            self::STONECUTTER => throw new Exception('To be implemented'),
            self::STRIPPED_ACACIA_LOG => throw new Exception('To be implemented'),
            self::STRIPPED_ACACIA_WOOD => throw new Exception('To be implemented'),
            self::STRIPPED_BAMBOO_BLOCK => throw new Exception('To be implemented'),
            self::STRIPPED_BIRCH_LOG => throw new Exception('To be implemented'),
            self::STRIPPED_BIRCH_WOOD => throw new Exception('To be implemented'),
            self::STRIPPED_CHERRY_LOG => throw new Exception('To be implemented'),
            self::STRIPPED_CHERRY_WOOD => throw new Exception('To be implemented'),
            self::STRIPPED_CRIMSON_HYPHAE => throw new Exception('To be implemented'),
            self::STRIPPED_CRIMSON_STEM => throw new Exception('To be implemented'),
            self::STRIPPED_DARK_OAK_LOG => throw new Exception('To be implemented'),
            self::STRIPPED_DARK_OAK_WOOD => throw new Exception('To be implemented'),
            self::STRIPPED_JUNGLE_LOG => throw new Exception('To be implemented'),
            self::STRIPPED_JUNGLE_WOOD => throw new Exception('To be implemented'),
            self::STRIPPED_MANGROVE_LOG => throw new Exception('To be implemented'),
            self::STRIPPED_MANGROVE_WOOD => throw new Exception('To be implemented'),
            self::STRIPPED_PALE_OAK_LOG => throw new Exception('To be implemented'),
            self::STRIPPED_PALE_OAK_WOOD => throw new Exception('To be implemented'),
            self::STRIPPED_SPRUCE_LOG => throw new Exception('To be implemented'),
            self::STRIPPED_SPRUCE_WOOD => throw new Exception('To be implemented'),
            self::STRIPPED_WARPED_HYPHAE => throw new Exception('To be implemented'),
            self::STRIPPED_WARPED_STEM => throw new Exception('To be implemented'),
            self::STRUCTURE_BLOCK => throw new Exception('To be implemented'),
            self::STRUCTURE_VOID => throw new Exception('To be implemented'),
            self::SUGAR_CANE => throw new Exception('To be implemented'),
            self::SUNFLOWER => throw new Exception('To be implemented'),
            self::SUSPICIOUS_GRAVEL => throw new Exception('To be implemented'),
            self::SUSPICIOUS_SAND => throw new Exception('To be implemented'),
            self::SWEET_BERRY_BUSH => throw new Exception('To be implemented'),
            self::TALL_DRY_GRASS => throw new Exception('To be implemented'),
            self::TALL_GRASS => GenericBisected::class,
            self::TALL_SEAGRASS => throw new Exception('To be implemented'),
            self::TARGET => throw new Exception('To be implemented'),
            self::TERRACOTTA => throw new Exception('To be implemented'),
            self::TEST_BLOCK => throw new Exception('To be implemented'),
            self::TEST_INSTANCE_BLOCK => throw new Exception('To be implemented'),
            self::TINTED_GLASS => throw new Exception('To be implemented'),
            self::TNT => throw new Exception('To be implemented'),
            self::TORCH => throw new Exception('To be implemented'),
            self::TORCHFLOWER => throw new Exception('To be implemented'),
            self::TORCHFLOWER_CROP => throw new Exception('To be implemented'),
            self::TRAPPED_CHEST => throw new Exception('To be implemented'),
            self::TRIAL_SPAWNER => throw new Exception('To be implemented'),
            self::TRIPWIRE => throw new Exception('To be implemented'),
            self::TRIPWIRE_HOOK => throw new Exception('To be implemented'),
            self::TUBE_CORAL => throw new Exception('To be implemented'),
            self::TUBE_CORAL_BLOCK => throw new Exception('To be implemented'),
            self::TUBE_CORAL_FAN => throw new Exception('To be implemented'),
            self::TUBE_CORAL_WALL_FAN => throw new Exception('To be implemented'),
            self::TUFF => throw new Exception('To be implemented'),
            self::TUFF_BRICK_SLAB => throw new Exception('To be implemented'),
            self::TUFF_BRICK_STAIRS => throw new Exception('To be implemented'),
            self::TUFF_BRICK_WALL => throw new Exception('To be implemented'),
            self::TUFF_BRICKS => throw new Exception('To be implemented'),
            self::TUFF_SLAB => throw new Exception('To be implemented'),
            self::TUFF_STAIRS => throw new Exception('To be implemented'),
            self::TUFF_WALL => throw new Exception('To be implemented'),
            self::TURTLE_EGG => throw new Exception('To be implemented'),
            self::TWISTING_VINES => throw new Exception('To be implemented'),
            self::TWISTING_VINES_PLANT => throw new Exception('To be implemented'),
            self::VAULT => throw new Exception('To be implemented'),
            self::VERDANT_FROGLIGHT => throw new Exception('To be implemented'),
            self::VINE => throw new Exception('To be implemented'),
            self::VOID_AIR => throw new Exception('To be implemented'),
            self::WALL_TORCH => GenericBlockData::class, // TODO: Implement real logic
            self::WARPED_BUTTON => throw new Exception('To be implemented'),
            self::WARPED_DOOR => throw new Exception('To be implemented'),
            self::WARPED_FENCE_GATE => throw new Exception('To be implemented'),
            self::WARPED_FUNGUS => throw new Exception('To be implemented'),
            self::WARPED_HANGING_SIGN => throw new Exception('To be implemented'),
            self::WARPED_HYPHAE => throw new Exception('To be implemented'),
            self::WARPED_NYLIUM => throw new Exception('To be implemented'),
            self::WARPED_PLANKS => throw new Exception('To be implemented'),
            self::WARPED_PRESSURE_PLATE => throw new Exception('To be implemented'),
            self::WARPED_ROOTS => throw new Exception('To be implemented'),
            self::WARPED_SIGN => throw new Exception('To be implemented'),
            self::WARPED_SLAB => throw new Exception('To be implemented'),
            self::WARPED_STAIRS => throw new Exception('To be implemented'),
            self::WARPED_STEM => throw new Exception('To be implemented'),
            self::WARPED_TRAPDOOR => throw new Exception('To be implemented'),
            self::WARPED_WALL_HANGING_SIGN => throw new Exception('To be implemented'),
            self::WARPED_WALL_SIGN => throw new Exception('To be implemented'),
            self::WARPED_WART_BLOCK => throw new Exception('To be implemented'),
            self::WATER => throw new Exception('To be implemented'),
            self::WATER_CAULDRON => throw new Exception('To be implemented'),
            self::WAXED_CHISELED_COPPER => throw new Exception('To be implemented'),
            self::WAXED_COPPER_BLOCK => throw new Exception('To be implemented'),
            self::WAXED_COPPER_BULB => throw new Exception('To be implemented'),
            self::WAXED_COPPER_DOOR => throw new Exception('To be implemented'),
            self::WAXED_COPPER_GRATE => throw new Exception('To be implemented'),
            self::WAXED_COPPER_TRAPDOOR => throw new Exception('To be implemented'),
            self::WAXED_CUT_COPPER => throw new Exception('To be implemented'),
            self::WAXED_CUT_COPPER_SLAB => throw new Exception('To be implemented'),
            self::WAXED_CUT_COPPER_STAIRS => throw new Exception('To be implemented'),
            self::WAXED_EXPOSED_CHISELED_COPPER => throw new Exception('To be implemented'),
            self::WAXED_EXPOSED_COPPER => throw new Exception('To be implemented'),
            self::WAXED_EXPOSED_COPPER_BULB => throw new Exception('To be implemented'),
            self::WAXED_EXPOSED_COPPER_DOOR => throw new Exception('To be implemented'),
            self::WAXED_EXPOSED_COPPER_GRATE => throw new Exception('To be implemented'),
            self::WAXED_EXPOSED_COPPER_TRAPDOOR => throw new Exception('To be implemented'),
            self::WAXED_EXPOSED_CUT_COPPER => throw new Exception('To be implemented'),
            self::WAXED_EXPOSED_CUT_COPPER_SLAB => throw new Exception('To be implemented'),
            self::WAXED_EXPOSED_CUT_COPPER_STAIRS => throw new Exception('To be implemented'),
            self::WAXED_OXIDIZED_CHISELED_COPPER => throw new Exception('To be implemented'),
            self::WAXED_OXIDIZED_COPPER => throw new Exception('To be implemented'),
            self::WAXED_OXIDIZED_COPPER_BULB => throw new Exception('To be implemented'),
            self::WAXED_OXIDIZED_COPPER_DOOR => throw new Exception('To be implemented'),
            self::WAXED_OXIDIZED_COPPER_GRATE => throw new Exception('To be implemented'),
            self::WAXED_OXIDIZED_COPPER_TRAPDOOR => throw new Exception('To be implemented'),
            self::WAXED_OXIDIZED_CUT_COPPER => throw new Exception('To be implemented'),
            self::WAXED_OXIDIZED_CUT_COPPER_SLAB => throw new Exception('To be implemented'),
            self::WAXED_OXIDIZED_CUT_COPPER_STAIRS => throw new Exception('To be implemented'),
            self::WAXED_WEATHERED_CHISELED_COPPER => throw new Exception('To be implemented'),
            self::WAXED_WEATHERED_COPPER => throw new Exception('To be implemented'),
            self::WAXED_WEATHERED_COPPER_BULB => throw new Exception('To be implemented'),
            self::WAXED_WEATHERED_COPPER_DOOR => throw new Exception('To be implemented'),
            self::WAXED_WEATHERED_COPPER_GRATE => throw new Exception('To be implemented'),
            self::WAXED_WEATHERED_COPPER_TRAPDOOR => throw new Exception('To be implemented'),
            self::WAXED_WEATHERED_CUT_COPPER => throw new Exception('To be implemented'),
            self::WAXED_WEATHERED_CUT_COPPER_SLAB => throw new Exception('To be implemented'),
            self::WAXED_WEATHERED_CUT_COPPER_STAIRS => throw new Exception('To be implemented'),
            self::WEATHERED_CHISELED_COPPER => throw new Exception('To be implemented'),
            self::WEATHERED_COPPER => throw new Exception('To be implemented'),
            self::WEATHERED_COPPER_BULB => throw new Exception('To be implemented'),
            self::WEATHERED_COPPER_DOOR => throw new Exception('To be implemented'),
            self::WEATHERED_COPPER_GRATE => throw new Exception('To be implemented'),
            self::WEATHERED_COPPER_TRAPDOOR => throw new Exception('To be implemented'),
            self::WEATHERED_CUT_COPPER => throw new Exception('To be implemented'),
            self::WEATHERED_CUT_COPPER_SLAB => throw new Exception('To be implemented'),
            self::WEATHERED_CUT_COPPER_STAIRS => throw new Exception('To be implemented'),
            self::WEEPING_VINES => throw new Exception('To be implemented'),
            self::WEEPING_VINES_PLANT => throw new Exception('To be implemented'),
            self::WET_SPONGE => throw new Exception('To be implemented'),
            self::WHEAT => throw new Exception('To be implemented'),
            self::WHITE_BANNER => throw new Exception('To be implemented'),
            self::WHITE_CANDLE => throw new Exception('To be implemented'),
            self::WHITE_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::WHITE_CARPET => throw new Exception('To be implemented'),
            self::WHITE_CONCRETE => throw new Exception('To be implemented'),
            self::WHITE_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::WHITE_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::WHITE_SHULKER_BOX => throw new Exception('To be implemented'),
            self::WHITE_STAINED_GLASS => throw new Exception('To be implemented'),
            self::WHITE_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::WHITE_TERRACOTTA => throw new Exception('To be implemented'),
            self::WHITE_TULIP => throw new Exception('To be implemented'),
            self::WHITE_WALL_BANNER => throw new Exception('To be implemented'),
            self::WILDFLOWERS => throw new Exception('To be implemented'),
            self::WITHER_ROSE => throw new Exception('To be implemented'),
            self::WITHER_SKELETON_SKULL => throw new Exception('To be implemented'),
            self::WITHER_SKELETON_WALL_SKULL => throw new Exception('To be implemented'),
            self::YELLOW_BANNER => throw new Exception('To be implemented'),
            self::YELLOW_BED => throw new Exception('To be implemented'),
            self::YELLOW_CANDLE => throw new Exception('To be implemented'),
            self::YELLOW_CANDLE_CAKE => throw new Exception('To be implemented'),
            self::YELLOW_CONCRETE => throw new Exception('To be implemented'),
            self::YELLOW_CONCRETE_POWDER => throw new Exception('To be implemented'),
            self::YELLOW_GLAZED_TERRACOTTA => throw new Exception('To be implemented'),
            self::YELLOW_SHULKER_BOX => throw new Exception('To be implemented'),
            self::YELLOW_STAINED_GLASS => throw new Exception('To be implemented'),
            self::YELLOW_STAINED_GLASS_PANE => throw new Exception('To be implemented'),
            self::YELLOW_TERRACOTTA => throw new Exception('To be implemented'),
            self::YELLOW_WALL_BANNER => throw new Exception('To be implemented'),
            self::ZOMBIE_HEAD => throw new Exception('To be implemented'),
            self::ZOMBIE_WALL_HEAD => throw new Exception('To be implemented'),
        };
    }

    public function createBlockData(): ?BlockData
    {
        try {
            $class = $this->getBlockDataClass();
        } catch (Exception) {
            $class = GenericBlockData::class;
        }

        if (!class_exists($class)) {
            return null;
        }

        $materialName = strtoupper($this->name);
        $material = constant(Material::class . '::' . $materialName);

        return new $class($material);
    }

    public function getKey(): string
    {
        return 'minecraft:' . strtolower($this->name);
    }

    public static function find(string|Material $block): BlockType
     {
        if (is_string($block)) {
            $key = str_replace("minecraft:", "", $block);
            $key = strtoupper($key);

            return constant(BlockType::class . '::' . $key);
        }

        return constant(BlockType::class . '::' . $block->name);
    }
}