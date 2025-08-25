<?php

namespace Nirbose\PhpMcServ\Block;

use Exception;
use Nirbose\PhpMcServ\Material;
use Nirbose\PhpMcServ\Block\Type\AgeBlockData;
use Nirbose\PhpMcServ\Block\Type\AmethystCluster;
use Nirbose\PhpMcServ\Block\Type\AxisBlockData;
use Nirbose\PhpMcServ\Block\Type\Bamboo;
use Nirbose\PhpMcServ\Block\Type\Barrel;
use Nirbose\PhpMcServ\Block\Type\Bed;
use Nirbose\PhpMcServ\Block\Type\Beehive;
use Nirbose\PhpMcServ\Block\Type\Bell;
use Nirbose\PhpMcServ\Block\Type\BigDripleaf;
use Nirbose\PhpMcServ\Block\Type\BigDripleafStem;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Type\BrewingStand;
use Nirbose\PhpMcServ\Block\Type\Cake;
use Nirbose\PhpMcServ\Block\Type\Campfire;
use Nirbose\PhpMcServ\Block\Type\Candle;
use Nirbose\PhpMcServ\Block\Type\CaveVines;
use Nirbose\PhpMcServ\Block\Type\CaveVinesPlant;
use Nirbose\PhpMcServ\Block\Type\Chain;
use Nirbose\PhpMcServ\Block\Type\Chest;
use Nirbose\PhpMcServ\Block\Type\ChiseledBookshelf;
use Nirbose\PhpMcServ\Block\Type\Cocoa;
use Nirbose\PhpMcServ\Block\Type\CommandBlock;
use Nirbose\PhpMcServ\Block\Type\Comparator;
use Nirbose\PhpMcServ\Block\Type\CopperBulb;
use Nirbose\PhpMcServ\Block\Type\Crafter;
use Nirbose\PhpMcServ\Block\Type\CreakingHeart;
use Nirbose\PhpMcServ\Block\Type\DaylightDetector;
use Nirbose\PhpMcServ\Block\Type\DecoratedPot;
use Nirbose\PhpMcServ\Block\Type\Dispenser;
use Nirbose\PhpMcServ\Block\Type\Door;
use Nirbose\PhpMcServ\Block\Type\DragBlockData;
use Nirbose\PhpMcServ\Block\Type\Dropper;
use Nirbose\PhpMcServ\Block\Type\DustedBlockData;
use Nirbose\PhpMcServ\Block\Type\EndPortalFrame;
use Nirbose\PhpMcServ\Block\Type\FacingBlockData;
use Nirbose\PhpMcServ\Block\Type\Farmland;
use Nirbose\PhpMcServ\Block\Type\Fence;
use Nirbose\PhpMcServ\Block\Type\Fire;
use Nirbose\PhpMcServ\Block\Type\Furnace;
use Nirbose\PhpMcServ\Block\Type\Gate;
use Nirbose\PhpMcServ\Block\Type\GlassPane;
use Nirbose\PhpMcServ\Block\Type\GlowLichen;
use Nirbose\PhpMcServ\Block\Type\Grindstone;
use Nirbose\PhpMcServ\Block\Type\HalfBlockData;
use Nirbose\PhpMcServ\Block\Type\HatchBlockData;
use Nirbose\PhpMcServ\Block\Type\Hopper;
use Nirbose\PhpMcServ\Block\Type\IronBars;
use Nirbose\PhpMcServ\Block\Type\Jukebox;
use Nirbose\PhpMcServ\Block\Type\Ladder;
use Nirbose\PhpMcServ\Block\Type\Lantern;
use Nirbose\PhpMcServ\Block\Type\LargeAmethystBud;
use Nirbose\PhpMcServ\Block\Type\LayersBlockData;
use Nirbose\PhpMcServ\Block\Type\LeafLitter;
use Nirbose\PhpMcServ\Block\Type\Leaves;
use Nirbose\PhpMcServ\Block\Type\Lectern;
use Nirbose\PhpMcServ\Block\Type\LevelBlockData;
use Nirbose\PhpMcServ\Block\Type\Light;
use Nirbose\PhpMcServ\Block\Type\LightningRod;
use Nirbose\PhpMcServ\Block\Type\LitBlockData;
use Nirbose\PhpMcServ\Block\Type\MangrovePropagule;
use Nirbose\PhpMcServ\Block\Type\MediumAmethystBud;
use Nirbose\PhpMcServ\Block\Type\ModeBlockData;
use Nirbose\PhpMcServ\Block\Type\MovingPiston;
use Nirbose\PhpMcServ\Block\Type\MultipleFacingBlockData;
use Nirbose\PhpMcServ\Block\Type\NoteBlock;
use Nirbose\PhpMcServ\Block\Type\Observer;
use Nirbose\PhpMcServ\Block\Type\OrientationBlockData;
use Nirbose\PhpMcServ\Block\Type\PaleMossCarpet;
use Nirbose\PhpMcServ\Block\Type\PinkPetals;
use Nirbose\PhpMcServ\Block\Type\Piston;
use Nirbose\PhpMcServ\Block\Type\PitcherCrop;
use Nirbose\PhpMcServ\Block\Type\PointedDripstone;
use Nirbose\PhpMcServ\Block\Type\PowerBlockData;
use Nirbose\PhpMcServ\Block\Type\PowerSwitch;
use Nirbose\PhpMcServ\Block\Type\PoweredBlockData;
use Nirbose\PhpMcServ\Block\Type\Rail;
use Nirbose\PhpMcServ\Block\Type\RedstoneRail;
use Nirbose\PhpMcServ\Block\Type\RedstoneWire;
use Nirbose\PhpMcServ\Block\Type\Repeater;
use Nirbose\PhpMcServ\Block\Type\ResinClump;
use Nirbose\PhpMcServ\Block\Type\RespawnAnchor;
use Nirbose\PhpMcServ\Block\Type\RotationBlockData;
use Nirbose\PhpMcServ\Block\Type\Scaffolding;
use Nirbose\PhpMcServ\Block\Type\SculkCatalyst;
use Nirbose\PhpMcServ\Block\Type\SculkSensor;
use Nirbose\PhpMcServ\Block\Type\SculkShrieker;
use Nirbose\PhpMcServ\Block\Type\SculkVein;
use Nirbose\PhpMcServ\Block\Type\SeaPickle;
use Nirbose\PhpMcServ\Block\Type\Sign;
use Nirbose\PhpMcServ\Block\Type\Skull;
use Nirbose\PhpMcServ\Block\Type\Slab;
use Nirbose\PhpMcServ\Block\Type\SmallAmethystBud;
use Nirbose\PhpMcServ\Block\Type\SmallDripleaf;
use Nirbose\PhpMcServ\Block\Type\Smoker;
use Nirbose\PhpMcServ\Block\Type\SnowyBlockData;
use Nirbose\PhpMcServ\Block\Type\SoulLantern;
use Nirbose\PhpMcServ\Block\Type\StageBlockData;
use Nirbose\PhpMcServ\Block\Type\Stairs;
use Nirbose\PhpMcServ\Block\Type\StickyPiston;
use Nirbose\PhpMcServ\Block\Type\TipBlockData;
use Nirbose\PhpMcServ\Block\Type\Tnt;
use Nirbose\PhpMcServ\Block\Type\Trapdoor;
use Nirbose\PhpMcServ\Block\Type\TrialSpawner;
use Nirbose\PhpMcServ\Block\Type\Tripwire;
use Nirbose\PhpMcServ\Block\Type\TripwireHook;
use Nirbose\PhpMcServ\Block\Type\TurtleEgg;
use Nirbose\PhpMcServ\Block\Type\Vault;
use Nirbose\PhpMcServ\Block\Type\Wall;
use Nirbose\PhpMcServ\Block\Type\WaterloggedBlockData;
use Nirbose\PhpMcServ\Block\Type\Wildflowers;

// This file is automatically generated. Do not edit manually.
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

    public function getBlockDataClass(): string
    {
        return match ($this) {
            self::ACACIA_BUTTON, self::BAMBOO_BUTTON, self::BIRCH_BUTTON, self::CHERRY_BUTTON, self::CRIMSON_BUTTON, self::DARK_OAK_BUTTON, self::JUNGLE_BUTTON, self::LEVER, self::MANGROVE_BUTTON, self::OAK_BUTTON, self::PALE_OAK_BUTTON, self::POLISHED_BLACKSTONE_BUTTON, self::SPRUCE_BUTTON, self::STONE_BUTTON, self::WARPED_BUTTON => PowerSwitch::class,
            self::ACACIA_DOOR, self::BAMBOO_DOOR, self::BIRCH_DOOR, self::CHERRY_DOOR, self::COPPER_DOOR, self::CRIMSON_DOOR, self::DARK_OAK_DOOR, self::EXPOSED_COPPER_DOOR, self::IRON_DOOR, self::JUNGLE_DOOR, self::MANGROVE_DOOR, self::OAK_DOOR, self::OXIDIZED_COPPER_DOOR, self::PALE_OAK_DOOR, self::SPRUCE_DOOR, self::WARPED_DOOR, self::WAXED_COPPER_DOOR, self::WAXED_EXPOSED_COPPER_DOOR, self::WAXED_OXIDIZED_COPPER_DOOR, self::WAXED_WEATHERED_COPPER_DOOR, self::WEATHERED_COPPER_DOOR => Door::class,
            self::ACACIA_FENCE, self::BAMBOO_FENCE, self::BIRCH_FENCE, self::CHERRY_FENCE, self::CRIMSON_FENCE, self::DARK_OAK_FENCE, self::JUNGLE_FENCE, self::MANGROVE_FENCE, self::NETHER_BRICK_FENCE, self::OAK_FENCE, self::PALE_OAK_FENCE, self::SPRUCE_FENCE, self::WARPED_FENCE => Fence::class,
            self::ACACIA_FENCE_GATE, self::BAMBOO_FENCE_GATE, self::BIRCH_FENCE_GATE, self::CHERRY_FENCE_GATE, self::CRIMSON_FENCE_GATE, self::DARK_OAK_FENCE_GATE, self::END_GATEWAY, self::JUNGLE_FENCE_GATE, self::MANGROVE_FENCE_GATE, self::OAK_FENCE_GATE, self::PALE_OAK_FENCE_GATE, self::SPRUCE_FENCE_GATE, self::WARPED_FENCE_GATE => Gate::class,
            self::ACACIA_HANGING_SIGN, self::ACACIA_SIGN, self::ACACIA_WALL_HANGING_SIGN, self::ACACIA_WALL_SIGN, self::BAMBOO_HANGING_SIGN, self::BAMBOO_SIGN, self::BAMBOO_WALL_HANGING_SIGN, self::BAMBOO_WALL_SIGN, self::BIRCH_HANGING_SIGN, self::BIRCH_SIGN, self::BIRCH_WALL_HANGING_SIGN, self::BIRCH_WALL_SIGN, self::CHERRY_HANGING_SIGN, self::CHERRY_SIGN, self::CHERRY_WALL_HANGING_SIGN, self::CHERRY_WALL_SIGN, self::CRIMSON_HANGING_SIGN, self::CRIMSON_SIGN, self::CRIMSON_WALL_HANGING_SIGN, self::CRIMSON_WALL_SIGN, self::DARK_OAK_HANGING_SIGN, self::DARK_OAK_SIGN, self::DARK_OAK_WALL_HANGING_SIGN, self::DARK_OAK_WALL_SIGN, self::JUNGLE_HANGING_SIGN, self::JUNGLE_SIGN, self::JUNGLE_WALL_HANGING_SIGN, self::JUNGLE_WALL_SIGN, self::MANGROVE_HANGING_SIGN, self::MANGROVE_SIGN, self::MANGROVE_WALL_HANGING_SIGN, self::MANGROVE_WALL_SIGN, self::OAK_HANGING_SIGN, self::OAK_SIGN, self::OAK_WALL_HANGING_SIGN, self::OAK_WALL_SIGN, self::PALE_OAK_HANGING_SIGN, self::PALE_OAK_SIGN, self::PALE_OAK_WALL_HANGING_SIGN, self::PALE_OAK_WALL_SIGN, self::SPRUCE_HANGING_SIGN, self::SPRUCE_SIGN, self::SPRUCE_WALL_HANGING_SIGN, self::SPRUCE_WALL_SIGN, self::WARPED_HANGING_SIGN, self::WARPED_SIGN, self::WARPED_WALL_HANGING_SIGN, self::WARPED_WALL_SIGN => Sign::class,
            self::ACACIA_LEAVES, self::AZALEA_LEAVES, self::BIRCH_LEAVES, self::CHERRY_LEAVES, self::DARK_OAK_LEAVES, self::FLOWERING_AZALEA_LEAVES, self::JUNGLE_LEAVES, self::MANGROVE_LEAVES, self::OAK_LEAVES, self::PALE_OAK_LEAVES, self::SPRUCE_LEAVES => Leaves::class,
            self::ACACIA_LOG, self::ACACIA_WOOD, self::BAMBOO_BLOCK, self::BASALT, self::BIRCH_LOG, self::BIRCH_WOOD, self::BONE_BLOCK, self::CHERRY_LOG, self::CHERRY_WOOD, self::CRIMSON_HYPHAE, self::CRIMSON_STEM, self::DARK_OAK_LOG, self::DARK_OAK_WOOD, self::DEEPSLATE, self::HAY_BLOCK, self::INFESTED_DEEPSLATE, self::JUNGLE_LOG, self::JUNGLE_WOOD, self::MANGROVE_LOG, self::MANGROVE_WOOD, self::MUDDY_MANGROVE_ROOTS, self::NETHER_PORTAL, self::OAK_LOG, self::OAK_WOOD, self::OCHRE_FROGLIGHT, self::PALE_OAK_LOG, self::PALE_OAK_WOOD, self::PEARLESCENT_FROGLIGHT, self::POLISHED_BASALT, self::PURPUR_PILLAR, self::QUARTZ_PILLAR, self::SPRUCE_LOG, self::SPRUCE_WOOD, self::STRIPPED_ACACIA_LOG, self::STRIPPED_ACACIA_WOOD, self::STRIPPED_BAMBOO_BLOCK, self::STRIPPED_BIRCH_LOG, self::STRIPPED_BIRCH_WOOD, self::STRIPPED_CHERRY_LOG, self::STRIPPED_CHERRY_WOOD, self::STRIPPED_CRIMSON_HYPHAE, self::STRIPPED_CRIMSON_STEM, self::STRIPPED_DARK_OAK_LOG, self::STRIPPED_DARK_OAK_WOOD, self::STRIPPED_JUNGLE_LOG, self::STRIPPED_JUNGLE_WOOD, self::STRIPPED_MANGROVE_LOG, self::STRIPPED_MANGROVE_WOOD, self::STRIPPED_OAK_LOG, self::STRIPPED_OAK_WOOD, self::STRIPPED_PALE_OAK_LOG, self::STRIPPED_PALE_OAK_WOOD, self::STRIPPED_SPRUCE_LOG, self::STRIPPED_SPRUCE_WOOD, self::STRIPPED_WARPED_HYPHAE, self::STRIPPED_WARPED_STEM, self::VERDANT_FROGLIGHT, self::WARPED_HYPHAE, self::WARPED_STEM => AxisBlockData::class,
            self::ACACIA_PRESSURE_PLATE, self::BAMBOO_PRESSURE_PLATE, self::BIRCH_PRESSURE_PLATE, self::CHERRY_PRESSURE_PLATE, self::CRIMSON_PRESSURE_PLATE, self::DARK_OAK_PRESSURE_PLATE, self::JUNGLE_PRESSURE_PLATE, self::MANGROVE_PRESSURE_PLATE, self::OAK_PRESSURE_PLATE, self::PALE_OAK_PRESSURE_PLATE, self::POLISHED_BLACKSTONE_PRESSURE_PLATE, self::SPRUCE_PRESSURE_PLATE, self::STONE_PRESSURE_PLATE, self::WARPED_PRESSURE_PLATE => PoweredBlockData::class,
            self::ACACIA_SAPLING, self::BIRCH_SAPLING, self::CHERRY_SAPLING, self::DARK_OAK_SAPLING, self::JUNGLE_SAPLING, self::OAK_SAPLING, self::PALE_OAK_SAPLING, self::SPRUCE_SAPLING => StageBlockData::class,
            self::ACACIA_SLAB, self::ANDESITE_SLAB, self::BAMBOO_MOSAIC_SLAB, self::BAMBOO_SLAB, self::BIRCH_SLAB, self::BLACKSTONE_SLAB, self::BRICK_SLAB, self::CHERRY_SLAB, self::COBBLED_DEEPSLATE_SLAB, self::COBBLESTONE_SLAB, self::CRIMSON_SLAB, self::CUT_COPPER_SLAB, self::CUT_RED_SANDSTONE_SLAB, self::CUT_SANDSTONE_SLAB, self::DARK_OAK_SLAB, self::DARK_PRISMARINE_SLAB, self::DEEPSLATE_BRICK_SLAB, self::DEEPSLATE_TILE_SLAB, self::DIORITE_SLAB, self::END_STONE_BRICK_SLAB, self::EXPOSED_CUT_COPPER_SLAB, self::GRANITE_SLAB, self::JUNGLE_SLAB, self::MANGROVE_SLAB, self::MOSSY_COBBLESTONE_SLAB, self::MOSSY_STONE_BRICK_SLAB, self::MUD_BRICK_SLAB, self::NETHER_BRICK_SLAB, self::OAK_SLAB, self::OXIDIZED_CUT_COPPER_SLAB, self::PALE_OAK_SLAB, self::PETRIFIED_OAK_SLAB, self::POLISHED_ANDESITE_SLAB, self::POLISHED_BLACKSTONE_BRICK_SLAB, self::POLISHED_BLACKSTONE_SLAB, self::POLISHED_DEEPSLATE_SLAB, self::POLISHED_DIORITE_SLAB, self::POLISHED_GRANITE_SLAB, self::POLISHED_TUFF_SLAB, self::PRISMARINE_BRICK_SLAB, self::PRISMARINE_SLAB, self::PURPUR_SLAB, self::QUARTZ_SLAB, self::RED_NETHER_BRICK_SLAB, self::RED_SANDSTONE_SLAB, self::RESIN_BRICK_SLAB, self::SANDSTONE_SLAB, self::SMOOTH_QUARTZ_SLAB, self::SMOOTH_RED_SANDSTONE_SLAB, self::SMOOTH_SANDSTONE_SLAB, self::SMOOTH_STONE_SLAB, self::SPRUCE_SLAB, self::STONE_BRICK_SLAB, self::STONE_SLAB, self::TUFF_BRICK_SLAB, self::TUFF_SLAB, self::WARPED_SLAB, self::WAXED_CUT_COPPER_SLAB, self::WAXED_EXPOSED_CUT_COPPER_SLAB, self::WAXED_OXIDIZED_CUT_COPPER_SLAB, self::WAXED_WEATHERED_CUT_COPPER_SLAB, self::WEATHERED_CUT_COPPER_SLAB => Slab::class,
            self::ACACIA_STAIRS, self::ANDESITE_STAIRS, self::BAMBOO_MOSAIC_STAIRS, self::BAMBOO_STAIRS, self::BIRCH_STAIRS, self::BLACKSTONE_STAIRS, self::BRICK_STAIRS, self::CHERRY_STAIRS, self::COBBLED_DEEPSLATE_STAIRS, self::COBBLESTONE_STAIRS, self::CRIMSON_STAIRS, self::CUT_COPPER_STAIRS, self::DARK_OAK_STAIRS, self::DARK_PRISMARINE_STAIRS, self::DEEPSLATE_BRICK_STAIRS, self::DEEPSLATE_TILE_STAIRS, self::DIORITE_STAIRS, self::END_STONE_BRICK_STAIRS, self::EXPOSED_CUT_COPPER_STAIRS, self::GRANITE_STAIRS, self::JUNGLE_STAIRS, self::MANGROVE_STAIRS, self::MOSSY_COBBLESTONE_STAIRS, self::MOSSY_STONE_BRICK_STAIRS, self::MUD_BRICK_STAIRS, self::NETHER_BRICK_STAIRS, self::OAK_STAIRS, self::OXIDIZED_CUT_COPPER_STAIRS, self::PALE_OAK_STAIRS, self::POLISHED_ANDESITE_STAIRS, self::POLISHED_BLACKSTONE_BRICK_STAIRS, self::POLISHED_BLACKSTONE_STAIRS, self::POLISHED_DEEPSLATE_STAIRS, self::POLISHED_DIORITE_STAIRS, self::POLISHED_GRANITE_STAIRS, self::POLISHED_TUFF_STAIRS, self::PRISMARINE_BRICK_STAIRS, self::PRISMARINE_STAIRS, self::PURPUR_STAIRS, self::QUARTZ_STAIRS, self::RED_NETHER_BRICK_STAIRS, self::RED_SANDSTONE_STAIRS, self::RESIN_BRICK_STAIRS, self::SANDSTONE_STAIRS, self::SMOOTH_QUARTZ_STAIRS, self::SMOOTH_RED_SANDSTONE_STAIRS, self::SMOOTH_SANDSTONE_STAIRS, self::SPRUCE_STAIRS, self::STONE_BRICK_STAIRS, self::STONE_STAIRS, self::TUFF_BRICK_STAIRS, self::TUFF_STAIRS, self::WARPED_STAIRS, self::WAXED_CUT_COPPER_STAIRS, self::WAXED_EXPOSED_CUT_COPPER_STAIRS, self::WAXED_OXIDIZED_CUT_COPPER_STAIRS, self::WAXED_WEATHERED_CUT_COPPER_STAIRS, self::WEATHERED_CUT_COPPER_STAIRS => Stairs::class,
            self::ACACIA_TRAPDOOR, self::BAMBOO_TRAPDOOR, self::BIRCH_TRAPDOOR, self::CHERRY_TRAPDOOR, self::COPPER_TRAPDOOR, self::CRIMSON_TRAPDOOR, self::DARK_OAK_TRAPDOOR, self::EXPOSED_COPPER_TRAPDOOR, self::IRON_TRAPDOOR, self::JUNGLE_TRAPDOOR, self::MANGROVE_TRAPDOOR, self::OAK_TRAPDOOR, self::OXIDIZED_COPPER_TRAPDOOR, self::PALE_OAK_TRAPDOOR, self::SPRUCE_TRAPDOOR, self::WARPED_TRAPDOOR, self::WAXED_COPPER_TRAPDOOR, self::WAXED_EXPOSED_COPPER_TRAPDOOR, self::WAXED_OXIDIZED_COPPER_TRAPDOOR, self::WAXED_WEATHERED_COPPER_TRAPDOOR, self::WEATHERED_COPPER_TRAPDOOR => Trapdoor::class,
            self::ACTIVATOR_RAIL, self::DETECTOR_RAIL, self::POWERED_RAIL => RedstoneRail::class,
            self::AMETHYST_CLUSTER => AmethystCluster::class,
            self::ANDESITE_WALL, self::BLACK_WALL_BANNER, self::BLACKSTONE_WALL, self::BLUE_WALL_BANNER, self::BRAIN_CORAL_WALL_FAN, self::BRICK_WALL, self::BROWN_WALL_BANNER, self::BUBBLE_CORAL_WALL_FAN, self::COBBLED_DEEPSLATE_WALL, self::COBBLESTONE_WALL, self::CREEPER_WALL_HEAD, self::CYAN_WALL_BANNER, self::DEAD_BRAIN_CORAL_WALL_FAN, self::DEAD_BUBBLE_CORAL_WALL_FAN, self::DEAD_FIRE_CORAL_WALL_FAN, self::DEAD_HORN_CORAL_WALL_FAN, self::DEAD_TUBE_CORAL_WALL_FAN, self::DEEPSLATE_BRICK_WALL, self::DEEPSLATE_TILE_WALL, self::DIORITE_WALL, self::DRAGON_WALL_HEAD, self::END_STONE_BRICK_WALL, self::FIRE_CORAL_WALL_FAN, self::GRANITE_WALL, self::GRAY_WALL_BANNER, self::GREEN_WALL_BANNER, self::HORN_CORAL_WALL_FAN, self::LIGHT_BLUE_WALL_BANNER, self::LIGHT_GRAY_WALL_BANNER, self::LIME_WALL_BANNER, self::MAGENTA_WALL_BANNER, self::MOSSY_COBBLESTONE_WALL, self::MOSSY_STONE_BRICK_WALL, self::MUD_BRICK_WALL, self::NETHER_BRICK_WALL, self::ORANGE_WALL_BANNER, self::PIGLIN_WALL_HEAD, self::PINK_WALL_BANNER, self::PLAYER_WALL_HEAD, self::POLISHED_BLACKSTONE_BRICK_WALL, self::POLISHED_BLACKSTONE_WALL, self::POLISHED_DEEPSLATE_WALL, self::POLISHED_TUFF_WALL, self::PRISMARINE_WALL, self::PURPLE_WALL_BANNER, self::RED_NETHER_BRICK_WALL, self::RED_SANDSTONE_WALL, self::RED_WALL_BANNER, self::REDSTONE_WALL_TORCH, self::RESIN_BRICK_WALL, self::SANDSTONE_WALL, self::SKELETON_WALL_SKULL, self::SOUL_WALL_TORCH, self::STONE_BRICK_WALL, self::TUBE_CORAL_WALL_FAN, self::TUFF_BRICK_WALL, self::TUFF_WALL, self::WHITE_WALL_BANNER, self::WITHER_SKELETON_WALL_SKULL, self::YELLOW_WALL_BANNER, self::ZOMBIE_WALL_HEAD => Wall::class,
            self::ANVIL, self::ATTACHED_MELON_STEM, self::ATTACHED_PUMPKIN_STEM, self::BLACK_GLAZED_TERRACOTTA, self::BLACK_SHULKER_BOX, self::BLUE_GLAZED_TERRACOTTA, self::BLUE_SHULKER_BOX, self::BROWN_GLAZED_TERRACOTTA, self::BROWN_SHULKER_BOX, self::CARVED_PUMPKIN, self::CHIPPED_ANVIL, self::CYAN_GLAZED_TERRACOTTA, self::CYAN_SHULKER_BOX, self::DAMAGED_ANVIL, self::END_ROD, self::GRAY_GLAZED_TERRACOTTA, self::GRAY_SHULKER_BOX, self::GREEN_GLAZED_TERRACOTTA, self::GREEN_SHULKER_BOX, self::JACK_O_LANTERN, self::LIGHT_BLUE_GLAZED_TERRACOTTA, self::LIGHT_BLUE_SHULKER_BOX, self::LIGHT_GRAY_GLAZED_TERRACOTTA, self::LIGHT_GRAY_SHULKER_BOX, self::LIME_GLAZED_TERRACOTTA, self::LIME_SHULKER_BOX, self::LOOM, self::MAGENTA_GLAZED_TERRACOTTA, self::MAGENTA_SHULKER_BOX, self::ORANGE_GLAZED_TERRACOTTA, self::ORANGE_SHULKER_BOX, self::PINK_GLAZED_TERRACOTTA, self::PINK_SHULKER_BOX, self::PURPLE_GLAZED_TERRACOTTA, self::PURPLE_SHULKER_BOX, self::RED_GLAZED_TERRACOTTA, self::RED_SHULKER_BOX, self::SHULKER_BOX, self::STONECUTTER, self::WALL_TORCH, self::WHITE_GLAZED_TERRACOTTA, self::WHITE_SHULKER_BOX, self::YELLOW_GLAZED_TERRACOTTA, self::YELLOW_SHULKER_BOX => FacingBlockData::class,
            self::BAMBOO => Bamboo::class,
            self::BARREL => Barrel::class,
            self::BARRIER, self::BRAIN_CORAL, self::BRAIN_CORAL_FAN, self::BUBBLE_CORAL, self::BUBBLE_CORAL_FAN, self::CONDUIT, self::COPPER_GRATE, self::DEAD_BRAIN_CORAL, self::DEAD_BRAIN_CORAL_FAN, self::DEAD_BUBBLE_CORAL, self::DEAD_BUBBLE_CORAL_FAN, self::DEAD_FIRE_CORAL, self::DEAD_FIRE_CORAL_FAN, self::DEAD_HORN_CORAL, self::DEAD_HORN_CORAL_FAN, self::DEAD_TUBE_CORAL, self::DEAD_TUBE_CORAL_FAN, self::EXPOSED_COPPER_GRATE, self::FIRE_CORAL, self::FIRE_CORAL_FAN, self::HANGING_ROOTS, self::HEAVY_CORE, self::HORN_CORAL, self::HORN_CORAL_FAN, self::MANGROVE_ROOTS, self::OXIDIZED_COPPER_GRATE, self::TUBE_CORAL, self::TUBE_CORAL_FAN, self::WAXED_COPPER_GRATE, self::WAXED_EXPOSED_COPPER_GRATE, self::WAXED_OXIDIZED_COPPER_GRATE, self::WAXED_WEATHERED_COPPER_GRATE, self::WEATHERED_COPPER_GRATE => WaterloggedBlockData::class,
            self::BEE_NEST, self::BEEHIVE => Beehive::class,
            self::BEETROOTS, self::CACTUS, self::CARROTS, self::CHORUS_FLOWER, self::FROSTED_ICE, self::KELP, self::MELON_STEM, self::NETHER_WART, self::POTATOES, self::PUMPKIN_STEM, self::SUGAR_CANE, self::SWEET_BERRY_BUSH, self::TORCHFLOWER_CROP, self::TWISTING_VINES, self::WEEPING_VINES, self::WHEAT => AgeBlockData::class,
            self::BELL => Bell::class,
            self::BIG_DRIPLEAF => BigDripleaf::class,
            self::BIG_DRIPLEAF_STEM => BigDripleafStem::class,
            self::BLACK_BANNER, self::BLUE_BANNER, self::BROWN_BANNER, self::CYAN_BANNER, self::GRAY_BANNER, self::GREEN_BANNER, self::LIGHT_BLUE_BANNER, self::LIGHT_GRAY_BANNER, self::LIME_BANNER, self::MAGENTA_BANNER, self::ORANGE_BANNER, self::PINK_BANNER, self::PURPLE_BANNER, self::RED_BANNER, self::WHITE_BANNER, self::YELLOW_BANNER => RotationBlockData::class,
            self::BLACK_BED, self::BLUE_BED, self::BROWN_BED, self::CYAN_BED, self::GRAY_BED, self::GREEN_BED, self::LIGHT_BLUE_BED, self::LIGHT_GRAY_BED, self::LIME_BED, self::MAGENTA_BED, self::ORANGE_BED, self::PINK_BED, self::PURPLE_BED, self::RED_BED, self::WHITE_BED, self::YELLOW_BED => Bed::class,
            self::BLACK_CANDLE, self::BLUE_CANDLE, self::BROWN_CANDLE, self::CANDLE, self::CYAN_CANDLE, self::GRAY_CANDLE, self::GREEN_CANDLE, self::LIGHT_BLUE_CANDLE, self::LIGHT_GRAY_CANDLE, self::LIME_CANDLE, self::MAGENTA_CANDLE, self::ORANGE_CANDLE, self::PINK_CANDLE, self::PURPLE_CANDLE, self::RED_CANDLE, self::WHITE_CANDLE, self::YELLOW_CANDLE => Candle::class,
            self::BLACK_CANDLE_CAKE, self::BLUE_CANDLE_CAKE, self::BROWN_CANDLE_CAKE, self::CANDLE_CAKE, self::CYAN_CANDLE_CAKE, self::DEEPSLATE_REDSTONE_ORE, self::GRAY_CANDLE_CAKE, self::GREEN_CANDLE_CAKE, self::LIGHT_BLUE_CANDLE_CAKE, self::LIGHT_GRAY_CANDLE_CAKE, self::LIME_CANDLE_CAKE, self::MAGENTA_CANDLE_CAKE, self::ORANGE_CANDLE_CAKE, self::PINK_CANDLE_CAKE, self::PURPLE_CANDLE_CAKE, self::RED_CANDLE_CAKE, self::REDSTONE_LAMP, self::REDSTONE_ORE, self::REDSTONE_TORCH, self::WHITE_CANDLE_CAKE, self::YELLOW_CANDLE_CAKE => LitBlockData::class,
            self::BLACK_STAINED_GLASS_PANE, self::BLUE_STAINED_GLASS_PANE, self::BROWN_STAINED_GLASS_PANE, self::CYAN_STAINED_GLASS_PANE, self::GLASS_PANE, self::GRAY_STAINED_GLASS_PANE, self::GREEN_STAINED_GLASS_PANE, self::LIGHT_BLUE_STAINED_GLASS_PANE, self::LIGHT_GRAY_STAINED_GLASS_PANE, self::LIME_STAINED_GLASS_PANE, self::MAGENTA_STAINED_GLASS_PANE, self::ORANGE_STAINED_GLASS_PANE, self::PINK_STAINED_GLASS_PANE, self::PURPLE_STAINED_GLASS_PANE, self::RED_STAINED_GLASS_PANE, self::WHITE_STAINED_GLASS_PANE, self::YELLOW_STAINED_GLASS_PANE => GlassPane::class,
            self::BLAST_FURNACE, self::FURNACE => Furnace::class,
            self::BREWING_STAND => BrewingStand::class,
            self::BROWN_MUSHROOM_BLOCK, self::CHORUS_PLANT, self::MUSHROOM_STEM, self::RED_MUSHROOM_BLOCK, self::VINE => MultipleFacingBlockData::class,
            self::BUBBLE_COLUMN => DragBlockData::class,
            self::CAKE => Cake::class,
            self::CALIBRATED_SCULK_SENSOR, self::SCULK_SENSOR => SculkSensor::class,
            self::CAMPFIRE, self::SOUL_CAMPFIRE => Campfire::class,
            self::CAVE_VINES => CaveVines::class,
            self::CAVE_VINES_PLANT => CaveVinesPlant::class,
            self::CHAIN => Chain::class,
            self::CHAIN_COMMAND_BLOCK, self::COMMAND_BLOCK, self::REPEATING_COMMAND_BLOCK => CommandBlock::class,
            self::CHEST, self::ENDER_CHEST, self::TRAPPED_CHEST => Chest::class,
            self::CHISELED_BOOKSHELF => ChiseledBookshelf::class,
            self::COCOA => Cocoa::class,
            self::COMPARATOR => Comparator::class,
            self::COMPOSTER, self::LAVA, self::POWDER_SNOW_CAULDRON, self::WATER, self::WATER_CAULDRON => LevelBlockData::class,
            self::COPPER_BULB, self::EXPOSED_COPPER_BULB, self::OXIDIZED_COPPER_BULB, self::WAXED_COPPER_BULB, self::WAXED_EXPOSED_COPPER_BULB, self::WAXED_OXIDIZED_COPPER_BULB, self::WAXED_WEATHERED_COPPER_BULB, self::WEATHERED_COPPER_BULB => CopperBulb::class,
            self::CRAFTER => Crafter::class,
            self::CREAKING_HEART => CreakingHeart::class,
            self::CREEPER_HEAD, self::DRAGON_HEAD, self::PIGLIN_HEAD, self::PISTON_HEAD, self::PLAYER_HEAD, self::SKELETON_SKULL, self::WITHER_SKELETON_SKULL, self::ZOMBIE_HEAD => Skull::class,
            self::DAYLIGHT_DETECTOR => DaylightDetector::class,
            self::DECORATED_POT => DecoratedPot::class,
            self::DISPENSER => Dispenser::class,
            self::DROPPER => Dropper::class,
            self::END_PORTAL_FRAME => EndPortalFrame::class,
            self::FARMLAND => Farmland::class,
            self::FIRE => Fire::class,
            self::GLOW_LICHEN => GlowLichen::class,
            self::GRASS_BLOCK, self::MYCELIUM, self::PODZOL => SnowyBlockData::class,
            self::GRINDSTONE => Grindstone::class,
            self::HEAVY_WEIGHTED_PRESSURE_PLATE, self::LIGHT_WEIGHTED_PRESSURE_PLATE, self::TARGET => PowerBlockData::class,
            self::HOPPER => Hopper::class,
            self::IRON_BARS => IronBars::class,
            self::JIGSAW => OrientationBlockData::class,
            self::JUKEBOX => Jukebox::class,
            self::LADDER => Ladder::class,
            self::LANTERN => Lantern::class,
            self::LARGE_AMETHYST_BUD => LargeAmethystBud::class,
            self::LARGE_FERN, self::LILAC, self::PEONY, self::PITCHER_PLANT, self::ROSE_BUSH, self::SUNFLOWER, self::TALL_GRASS, self::TALL_SEAGRASS => HalfBlockData::class,
            self::LEAF_LITTER => LeafLitter::class,
            self::LECTERN => Lectern::class,
            self::LIGHT => Light::class,
            self::LIGHTNING_ROD => LightningRod::class,
            self::MANGROVE_PROPAGULE => MangrovePropagule::class,
            self::MEDIUM_AMETHYST_BUD => MediumAmethystBud::class,
            self::MOVING_PISTON => MovingPiston::class,
            self::NOTE_BLOCK => NoteBlock::class,
            self::OBSERVER => Observer::class,
            self::PALE_HANGING_MOSS => TipBlockData::class,
            self::PALE_MOSS_CARPET => PaleMossCarpet::class,
            self::PINK_PETALS => PinkPetals::class,
            self::PISTON => Piston::class,
            self::PITCHER_CROP => PitcherCrop::class,
            self::POINTED_DRIPSTONE => PointedDripstone::class,
            self::RAIL => Rail::class,
            self::REDSTONE_WIRE => RedstoneWire::class,
            self::REPEATER => Repeater::class,
            self::RESIN_CLUMP => ResinClump::class,
            self::RESPAWN_ANCHOR => RespawnAnchor::class,
            self::SCAFFOLDING => Scaffolding::class,
            self::SCULK_CATALYST => SculkCatalyst::class,
            self::SCULK_SHRIEKER => SculkShrieker::class,
            self::SCULK_VEIN => SculkVein::class,
            self::SEA_PICKLE => SeaPickle::class,
            self::SMALL_AMETHYST_BUD => SmallAmethystBud::class,
            self::SMALL_DRIPLEAF => SmallDripleaf::class,
            self::SMOKER => Smoker::class,
            self::SNIFFER_EGG => HatchBlockData::class,
            self::SNOW => LayersBlockData::class,
            self::SOUL_LANTERN => SoulLantern::class,
            self::STICKY_PISTON => StickyPiston::class,
            self::STRUCTURE_BLOCK, self::TEST_BLOCK => ModeBlockData::class,
            self::SUSPICIOUS_GRAVEL, self::SUSPICIOUS_SAND => DustedBlockData::class,
            self::TNT => Tnt::class,
            self::TRIAL_SPAWNER => TrialSpawner::class,
            self::TRIPWIRE => Tripwire::class,
            self::TRIPWIRE_HOOK => TripwireHook::class,
            self::TURTLE_EGG => TurtleEgg::class,
            self::VAULT => Vault::class,
            self::WILDFLOWERS => Wildflowers::class,
            self::ACACIA_PLANKS, self::AIR, self::ALLIUM, self::AMETHYST_BLOCK, self::ANCIENT_DEBRIS, self::ANDESITE, self::AZALEA, self::AZURE_BLUET, self::BAMBOO_MOSAIC, self::BAMBOO_PLANKS, self::BAMBOO_SAPLING, self::BEACON, self::BEDROCK, self::BIRCH_PLANKS, self::BLACK_CARPET, self::BLACK_CONCRETE, self::BLACK_CONCRETE_POWDER, self::BLACK_STAINED_GLASS, self::BLACK_TERRACOTTA, self::BLACK_WOOL, self::BLACKSTONE, self::BLUE_CARPET, self::BLUE_CONCRETE, self::BLUE_CONCRETE_POWDER, self::BLUE_ICE, self::BLUE_ORCHID, self::BLUE_STAINED_GLASS, self::BLUE_TERRACOTTA, self::BLUE_WOOL, self::BOOKSHELF, self::BRAIN_CORAL_BLOCK, self::BRICKS, self::BROWN_CARPET, self::BROWN_CONCRETE, self::BROWN_CONCRETE_POWDER, self::BROWN_MUSHROOM, self::BROWN_STAINED_GLASS, self::BROWN_TERRACOTTA, self::BROWN_WOOL, self::BUBBLE_CORAL_BLOCK, self::BUDDING_AMETHYST, self::BUSH, self::CACTUS_FLOWER, self::CALCITE, self::CARTOGRAPHY_TABLE, self::CAULDRON, self::CAVE_AIR, self::CHERRY_PLANKS, self::CHISELED_COPPER, self::CHISELED_DEEPSLATE, self::CHISELED_NETHER_BRICKS, self::CHISELED_POLISHED_BLACKSTONE, self::CHISELED_QUARTZ_BLOCK, self::CHISELED_RED_SANDSTONE, self::CHISELED_RESIN_BRICKS, self::CHISELED_SANDSTONE, self::CHISELED_STONE_BRICKS, self::CHISELED_TUFF, self::CHISELED_TUFF_BRICKS, self::CLAY, self::CLOSED_EYEBLOSSOM, self::COAL_BLOCK, self::COAL_ORE, self::COARSE_DIRT, self::COBBLED_DEEPSLATE, self::COBBLESTONE, self::COBWEB, self::COPPER_BLOCK, self::COPPER_ORE, self::CORNFLOWER, self::CRACKED_DEEPSLATE_BRICKS, self::CRACKED_DEEPSLATE_TILES, self::CRACKED_NETHER_BRICKS, self::CRACKED_POLISHED_BLACKSTONE_BRICKS, self::CRACKED_STONE_BRICKS, self::CRAFTING_TABLE, self::CRIMSON_FUNGUS, self::CRIMSON_NYLIUM, self::CRIMSON_PLANKS, self::CRIMSON_ROOTS, self::CRYING_OBSIDIAN, self::CUT_COPPER, self::CUT_RED_SANDSTONE, self::CUT_SANDSTONE, self::CYAN_CARPET, self::CYAN_CONCRETE, self::CYAN_CONCRETE_POWDER, self::CYAN_STAINED_GLASS, self::CYAN_TERRACOTTA, self::CYAN_WOOL, self::DANDELION, self::DARK_OAK_PLANKS, self::DARK_PRISMARINE, self::DEAD_BRAIN_CORAL_BLOCK, self::DEAD_BUBBLE_CORAL_BLOCK, self::DEAD_BUSH, self::DEAD_FIRE_CORAL_BLOCK, self::DEAD_HORN_CORAL_BLOCK, self::DEAD_TUBE_CORAL_BLOCK, self::DEEPSLATE_BRICKS, self::DEEPSLATE_COAL_ORE, self::DEEPSLATE_COPPER_ORE, self::DEEPSLATE_DIAMOND_ORE, self::DEEPSLATE_EMERALD_ORE, self::DEEPSLATE_GOLD_ORE, self::DEEPSLATE_IRON_ORE, self::DEEPSLATE_LAPIS_ORE, self::DEEPSLATE_TILES, self::DIAMOND_BLOCK, self::DIAMOND_ORE, self::DIORITE, self::DIRT, self::DIRT_PATH, self::DRAGON_EGG, self::DRIED_KELP_BLOCK, self::DRIPSTONE_BLOCK, self::EMERALD_BLOCK, self::EMERALD_ORE, self::ENCHANTING_TABLE, self::END_PORTAL, self::END_STONE, self::END_STONE_BRICKS, self::EXPOSED_CHISELED_COPPER, self::EXPOSED_COPPER, self::EXPOSED_CUT_COPPER, self::FERN, self::FIRE_CORAL_BLOCK, self::FIREFLY_BUSH, self::FLETCHING_TABLE, self::FLOWER_POT, self::FLOWERING_AZALEA, self::FROGSPAWN, self::GILDED_BLACKSTONE, self::GLASS, self::GLOWSTONE, self::GOLD_BLOCK, self::GOLD_ORE, self::GRANITE, self::GRAVEL, self::GRAY_CARPET, self::GRAY_CONCRETE, self::GRAY_CONCRETE_POWDER, self::GRAY_STAINED_GLASS, self::GRAY_TERRACOTTA, self::GRAY_WOOL, self::GREEN_CARPET, self::GREEN_CONCRETE, self::GREEN_CONCRETE_POWDER, self::GREEN_STAINED_GLASS, self::GREEN_TERRACOTTA, self::GREEN_WOOL, self::HONEY_BLOCK, self::HONEYCOMB_BLOCK, self::HORN_CORAL_BLOCK, self::ICE, self::INFESTED_CHISELED_STONE_BRICKS, self::INFESTED_COBBLESTONE, self::INFESTED_CRACKED_STONE_BRICKS, self::INFESTED_MOSSY_STONE_BRICKS, self::INFESTED_STONE, self::INFESTED_STONE_BRICKS, self::IRON_BLOCK, self::IRON_ORE, self::JUNGLE_PLANKS, self::KELP_PLANT, self::LAPIS_BLOCK, self::LAPIS_ORE, self::LAVA_CAULDRON, self::LIGHT_BLUE_CARPET, self::LIGHT_BLUE_CONCRETE, self::LIGHT_BLUE_CONCRETE_POWDER, self::LIGHT_BLUE_STAINED_GLASS, self::LIGHT_BLUE_TERRACOTTA, self::LIGHT_BLUE_WOOL, self::LIGHT_GRAY_CARPET, self::LIGHT_GRAY_CONCRETE, self::LIGHT_GRAY_CONCRETE_POWDER, self::LIGHT_GRAY_STAINED_GLASS, self::LIGHT_GRAY_TERRACOTTA, self::LIGHT_GRAY_WOOL, self::LILY_OF_THE_VALLEY, self::LILY_PAD, self::LIME_CARPET, self::LIME_CONCRETE, self::LIME_CONCRETE_POWDER, self::LIME_STAINED_GLASS, self::LIME_TERRACOTTA, self::LIME_WOOL, self::LODESTONE, self::MAGENTA_CARPET, self::MAGENTA_CONCRETE, self::MAGENTA_CONCRETE_POWDER, self::MAGENTA_STAINED_GLASS, self::MAGENTA_TERRACOTTA, self::MAGENTA_WOOL, self::MAGMA_BLOCK, self::MANGROVE_PLANKS, self::MELON, self::MOSS_BLOCK, self::MOSS_CARPET, self::MOSSY_COBBLESTONE, self::MOSSY_STONE_BRICKS, self::MUD, self::MUD_BRICKS, self::NETHER_BRICKS, self::NETHER_GOLD_ORE, self::NETHER_QUARTZ_ORE, self::NETHER_SPROUTS, self::NETHER_WART_BLOCK, self::NETHERITE_BLOCK, self::NETHERRACK, self::OAK_PLANKS, self::OBSIDIAN, self::OPEN_EYEBLOSSOM, self::ORANGE_CARPET, self::ORANGE_CONCRETE, self::ORANGE_CONCRETE_POWDER, self::ORANGE_STAINED_GLASS, self::ORANGE_TERRACOTTA, self::ORANGE_TULIP, self::ORANGE_WOOL, self::OXEYE_DAISY, self::OXIDIZED_CHISELED_COPPER, self::OXIDIZED_COPPER, self::OXIDIZED_CUT_COPPER, self::PACKED_ICE, self::PACKED_MUD, self::PALE_MOSS_BLOCK, self::PALE_OAK_PLANKS, self::PINK_CARPET, self::PINK_CONCRETE, self::PINK_CONCRETE_POWDER, self::PINK_STAINED_GLASS, self::PINK_TERRACOTTA, self::PINK_TULIP, self::PINK_WOOL, self::POLISHED_ANDESITE, self::POLISHED_BLACKSTONE, self::POLISHED_BLACKSTONE_BRICKS, self::POLISHED_DEEPSLATE, self::POLISHED_DIORITE, self::POLISHED_GRANITE, self::POLISHED_TUFF, self::POPPY, self::POTTED_ACACIA_SAPLING, self::POTTED_ALLIUM, self::POTTED_AZALEA_BUSH, self::POTTED_AZURE_BLUET, self::POTTED_BAMBOO, self::POTTED_BIRCH_SAPLING, self::POTTED_BLUE_ORCHID, self::POTTED_BROWN_MUSHROOM, self::POTTED_CACTUS, self::POTTED_CHERRY_SAPLING, self::POTTED_CLOSED_EYEBLOSSOM, self::POTTED_CORNFLOWER, self::POTTED_CRIMSON_FUNGUS, self::POTTED_CRIMSON_ROOTS, self::POTTED_DANDELION, self::POTTED_DARK_OAK_SAPLING, self::POTTED_DEAD_BUSH, self::POTTED_FERN, self::POTTED_FLOWERING_AZALEA_BUSH, self::POTTED_JUNGLE_SAPLING, self::POTTED_LILY_OF_THE_VALLEY, self::POTTED_MANGROVE_PROPAGULE, self::POTTED_OAK_SAPLING, self::POTTED_OPEN_EYEBLOSSOM, self::POTTED_ORANGE_TULIP, self::POTTED_OXEYE_DAISY, self::POTTED_PALE_OAK_SAPLING, self::POTTED_PINK_TULIP, self::POTTED_POPPY, self::POTTED_RED_MUSHROOM, self::POTTED_RED_TULIP, self::POTTED_SPRUCE_SAPLING, self::POTTED_TORCHFLOWER, self::POTTED_WARPED_FUNGUS, self::POTTED_WARPED_ROOTS, self::POTTED_WHITE_TULIP, self::POTTED_WITHER_ROSE, self::POWDER_SNOW, self::PRISMARINE, self::PRISMARINE_BRICKS, self::PUMPKIN, self::PURPLE_CARPET, self::PURPLE_CONCRETE, self::PURPLE_CONCRETE_POWDER, self::PURPLE_STAINED_GLASS, self::PURPLE_TERRACOTTA, self::PURPLE_WOOL, self::PURPUR_BLOCK, self::QUARTZ_BLOCK, self::QUARTZ_BRICKS, self::RAW_COPPER_BLOCK, self::RAW_GOLD_BLOCK, self::RAW_IRON_BLOCK, self::RED_CARPET, self::RED_CONCRETE, self::RED_CONCRETE_POWDER, self::RED_MUSHROOM, self::RED_NETHER_BRICKS, self::RED_SAND, self::RED_SANDSTONE, self::RED_STAINED_GLASS, self::RED_TERRACOTTA, self::RED_TULIP, self::RED_WOOL, self::REDSTONE_BLOCK, self::REINFORCED_DEEPSLATE, self::RESIN_BLOCK, self::RESIN_BRICKS, self::ROOTED_DIRT, self::SAND, self::SANDSTONE, self::SCULK, self::SEA_LANTERN, self::SEAGRASS, self::SHORT_DRY_GRASS, self::SHORT_GRASS, self::SHROOMLIGHT, self::SLIME_BLOCK, self::SMITHING_TABLE, self::SMOOTH_BASALT, self::SMOOTH_QUARTZ, self::SMOOTH_RED_SANDSTONE, self::SMOOTH_SANDSTONE, self::SMOOTH_STONE, self::SNOW_BLOCK, self::SOUL_FIRE, self::SOUL_SAND, self::SOUL_SOIL, self::SOUL_TORCH, self::SPAWNER, self::SPONGE, self::SPORE_BLOSSOM, self::SPRUCE_PLANKS, self::STONE, self::STONE_BRICKS, self::STRUCTURE_VOID, self::TALL_DRY_GRASS, self::TERRACOTTA, self::TEST_INSTANCE_BLOCK, self::TINTED_GLASS, self::TORCH, self::TORCHFLOWER, self::TUBE_CORAL_BLOCK, self::TUFF, self::TUFF_BRICKS, self::TWISTING_VINES_PLANT, self::VOID_AIR, self::WARPED_FUNGUS, self::WARPED_NYLIUM, self::WARPED_PLANKS, self::WARPED_ROOTS, self::WARPED_WART_BLOCK, self::WAXED_CHISELED_COPPER, self::WAXED_COPPER_BLOCK, self::WAXED_CUT_COPPER, self::WAXED_EXPOSED_CHISELED_COPPER, self::WAXED_EXPOSED_COPPER, self::WAXED_EXPOSED_CUT_COPPER, self::WAXED_OXIDIZED_CHISELED_COPPER, self::WAXED_OXIDIZED_COPPER, self::WAXED_OXIDIZED_CUT_COPPER, self::WAXED_WEATHERED_CHISELED_COPPER, self::WAXED_WEATHERED_COPPER, self::WAXED_WEATHERED_CUT_COPPER, self::WEATHERED_CHISELED_COPPER, self::WEATHERED_COPPER, self::WEATHERED_CUT_COPPER, self::WEEPING_VINES_PLANT, self::WET_SPONGE, self::WHITE_CARPET, self::WHITE_CONCRETE, self::WHITE_CONCRETE_POWDER, self::WHITE_STAINED_GLASS, self::WHITE_TERRACOTTA, self::WHITE_TULIP, self::WHITE_WOOL, self::WITHER_ROSE, self::YELLOW_CARPET, self::YELLOW_CONCRETE, self::YELLOW_CONCRETE_POWDER, self::YELLOW_STAINED_GLASS, self::YELLOW_TERRACOTTA, self::YELLOW_WOOL => BlockData::class,
        };
    }

    public function createBlockData(): BlockData
    {
        try {
            $class = $this->getBlockDataClass();
        } catch (Exception) {
            $class = BlockData::class;
        }

        if (!class_exists($class)) {
            $class = BlockData::class;
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

            return constant(self::class . '::' . $key);
        }

        return constant(self::class . '::' . $block->name);
    }
}