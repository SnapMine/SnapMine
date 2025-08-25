<?php

namespace SnapMine\Entity;

use SnapMine\Entity\Animal\Armadillo;
use SnapMine\Entity\Animal\Bee;
use SnapMine\Entity\Animal\Chicken;
use SnapMine\Entity\Animal\Cow;
use SnapMine\Entity\Animal\Fox;
use SnapMine\Entity\Animal\Frog;
use SnapMine\Entity\Animal\Goat;
use SnapMine\Entity\Animal\Hoglin;
use SnapMine\Entity\Animal\Mooshroom;
use SnapMine\Entity\Animal\Ocelot;
use SnapMine\Entity\Animal\Panda;
use SnapMine\Entity\Animal\Pig;
use SnapMine\Entity\Animal\Rabbit;
use SnapMine\Entity\Animal\Sheep;
use SnapMine\Entity\Animal\Sniffer;
use SnapMine\Entity\Animal\Strider;
use SnapMine\Entity\Animal\Turtle;

enum EntityType: int
{
	case ACACIA_BOAT = 0;
	case ACACIA_CHEST_BOAT = 1;
	case ALLAY = 2;
	case AREA_EFFECT_CLOUD = 3;
	case ARMADILLO = 4;
	case ARMOR_STAND = 5;
	case ARROW = 6;
	case AXOLOTL = 7;
	case BAMBOO_CHEST_RAFT = 8;
	case BAMBOO_RAFT = 9;
	case BAT = 10;
	case BEE = 11;
	case BIRCH_BOAT = 12;
	case BIRCH_CHEST_BOAT = 13;
	case BLAZE = 14;
	case BLOCK_DISPLAY = 15;
	case BOGGED = 16;
	case BREEZE = 17;
	case BREEZE_WIND_CHARGE = 18;
	case CAMEL = 19;
	case CAT = 20;
	case CAVE_SPIDER = 21;
	case CHERRY_BOAT = 22;
	case CHERRY_CHEST_BOAT = 23;
	case CHEST_MINECART = 24;
	case CHICKEN = 25;
	case COD = 26;
	case COMMAND_BLOCK_MINECART = 27;
	case COW = 28;
	case CREAKING = 29;
	case CREEPER = 30;
	case DARK_OAK_BOAT = 31;
	case DARK_OAK_CHEST_BOAT = 32;
	case DOLPHIN = 33;
	case DONKEY = 34;
	case DRAGON_FIREBALL = 35;
	case DROWNED = 36;
	case EGG = 37;
	case ELDER_GUARDIAN = 38;
	case END_CRYSTAL = 43;
	case ENDER_DRAGON = 41;
	case ENDER_PEARL = 42;
	case ENDERMAN = 39;
	case ENDERMITE = 40;
	case EVOKER = 44;
	case EVOKER_FANGS = 45;
	case EXPERIENCE_BOTTLE = 46;
	case EXPERIENCE_ORB = 47;
	case EYE_OF_ENDER = 48;
	case FALLING_BLOCK = 49;
	case FIREBALL = 50;
	case FIREWORK_ROCKET = 51;
	case FISHING_BOBBER = 149;
	case FOX = 52;
	case FROG = 53;
	case FURNACE_MINECART = 54;
	case GHAST = 55;
	case GIANT = 56;
	case GLOW_ITEM_FRAME = 57;
	case GLOW_SQUID = 58;
	case GOAT = 59;
	case GUARDIAN = 60;
	case HOGLIN = 61;
	case HOPPER_MINECART = 62;
	case HORSE = 63;
	case HUSK = 64;
	case ILLUSIONER = 65;
	case INTERACTION = 66;
	case IRON_GOLEM = 67;
	case ITEM = 68;
	case ITEM_DISPLAY = 69;
	case ITEM_FRAME = 70;
	case JUNGLE_BOAT = 71;
	case JUNGLE_CHEST_BOAT = 72;
	case LEASH_KNOT = 73;
	case LIGHTNING_BOLT = 74;
	case LINGERING_POTION = 100;
	case LLAMA = 75;
	case LLAMA_SPIT = 76;
	case MAGMA_CUBE = 77;
	case MANGROVE_BOAT = 78;
	case MANGROVE_CHEST_BOAT = 79;
	case MARKER = 80;
	case MINECART = 81;
	case MOOSHROOM = 82;
	case MULE = 83;
	case OAK_BOAT = 84;
	case OAK_CHEST_BOAT = 85;
	case OCELOT = 86;
	case OMINOUS_ITEM_SPAWNER = 87;
	case PAINTING = 88;
	case PALE_OAK_BOAT = 89;
	case PALE_OAK_CHEST_BOAT = 90;
	case PANDA = 91;
	case PARROT = 92;
	case PHANTOM = 93;
	case PIG = 94;
	case PIGLIN = 95;
	case PIGLIN_BRUTE = 96;
	case PILLAGER = 97;
	case PLAYER = 148;
	case POLAR_BEAR = 98;
	case PUFFERFISH = 101;
	case RABBIT = 102;
	case RAVAGER = 103;
	case SALMON = 104;
	case SHEEP = 105;
	case SHULKER = 106;
	case SHULKER_BULLET = 107;
	case SILVERFISH = 108;
	case SKELETON = 109;
	case SKELETON_HORSE = 110;
	case SLIME = 111;
	case SMALL_FIREBALL = 112;
	case SNIFFER = 113;
	case SNOW_GOLEM = 115;
	case SNOWBALL = 114;
	case SPAWNER_MINECART = 116;
	case SPECTRAL_ARROW = 117;
	case SPIDER = 118;
	case SPLASH_POTION = 99;
	case SPRUCE_BOAT = 119;
	case SPRUCE_CHEST_BOAT = 120;
	case SQUID = 121;
	case STRAY = 122;
	case STRIDER = 123;
	case TADPOLE = 124;
	case TEXT_DISPLAY = 125;
	case TNT = 126;
	case TNT_MINECART = 127;
	case TRADER_LLAMA = 128;
	case TRIDENT = 129;
	case TROPICAL_FISH = 130;
	case TURTLE = 131;
	case VEX = 132;
	case VILLAGER = 133;
	case VINDICATOR = 134;
	case WANDERING_TRADER = 135;
	case WARDEN = 136;
	case WIND_CHARGE = 137;
	case WITCH = 138;
	case WITHER = 139;
	case WITHER_SKELETON = 140;
	case WITHER_SKULL = 141;
	case WOLF = 142;
	case ZOGLIN = 143;
	case ZOMBIE = 144;
	case ZOMBIE_HORSE = 145;
	case ZOMBIE_VILLAGER = 146;
	case ZOMBIFIED_PIGLIN = 147;

    /**
     * @return class-string
     * @throws \Exception
     */
    public function getClass(): string
    {
        return match ($this) {
            EntityType::ACACIA_BOAT => throw new \Exception('To be implemented'),
            EntityType::ACACIA_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::ALLAY => throw new \Exception('To be implemented'),
            EntityType::AREA_EFFECT_CLOUD => AreaEffectCloud::class,
            EntityType::ARMADILLO => Armadillo::class,
            EntityType::ARMOR_STAND => throw new \Exception('To be implemented'),
            EntityType::ARROW => throw new \Exception('To be implemented'),
            EntityType::AXOLOTL => throw new \Exception('To be implemented'),
            EntityType::BAMBOO_CHEST_RAFT => throw new \Exception('To be implemented'),
            EntityType::BAMBOO_RAFT => throw new \Exception('To be implemented'),
            EntityType::BAT => throw new \Exception('To be implemented'),
            EntityType::BEE => Bee::class,
            EntityType::BIRCH_BOAT => throw new \Exception('To be implemented'),
            EntityType::BIRCH_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::BLAZE => throw new \Exception('To be implemented'),
            EntityType::BLOCK_DISPLAY => throw new \Exception('To be implemented'),
            EntityType::BOGGED => throw new \Exception('To be implemented'),
            EntityType::BREEZE => throw new \Exception('To be implemented'),
            EntityType::BREEZE_WIND_CHARGE => throw new \Exception('To be implemented'),
            EntityType::CAMEL => throw new \Exception('To be implemented'),
            EntityType::CAT => throw new \Exception('To be implemented'),
            EntityType::CAVE_SPIDER => throw new \Exception('To be implemented'),
            EntityType::CHERRY_BOAT => throw new \Exception('To be implemented'),
            EntityType::CHERRY_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::CHEST_MINECART => throw new \Exception('To be implemented'),
            EntityType::CHICKEN => Chicken::class,
            EntityType::COD => throw new \Exception('To be implemented'),
            EntityType::COMMAND_BLOCK_MINECART => throw new \Exception('To be implemented'),
            EntityType::COW => Cow::class,
            EntityType::CREAKING => throw new \Exception('To be implemented'),
            EntityType::CREEPER => throw new \Exception('To be implemented'),
            EntityType::DARK_OAK_BOAT => throw new \Exception('To be implemented'),
            EntityType::DARK_OAK_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::DOLPHIN => throw new \Exception('To be implemented'),
            EntityType::DONKEY => throw new \Exception('To be implemented'),
            EntityType::DRAGON_FIREBALL => DragonFireball::class,
            EntityType::DROWNED => throw new \Exception('To be implemented'),
            EntityType::EGG => throw new \Exception('To be implemented'),
            EntityType::ELDER_GUARDIAN => throw new \Exception('To be implemented'),
            EntityType::END_CRYSTAL => EndCrystal::class,
            EntityType::ENDER_DRAGON => throw new \Exception('To be implemented'),
            EntityType::ENDER_PEARL => throw new \Exception('To be implemented'),
            EntityType::ENDERMAN => throw new \Exception('To be implemented'),
            EntityType::ENDERMITE => throw new \Exception('To be implemented'),
            EntityType::EVOKER => throw new \Exception('To be implemented'),
            EntityType::EVOKER_FANGS => EvokerFangs::class,
            EntityType::EXPERIENCE_BOTTLE => throw new \Exception('To be implemented'),
            EntityType::EXPERIENCE_ORB => throw new \Exception('To be implemented'),
            EntityType::EYE_OF_ENDER => throw new \Exception('To be implemented'),
            EntityType::FALLING_BLOCK => throw new \Exception('To be implemented'),
            EntityType::FIREBALL => throw new \Exception('To be implemented'),
            EntityType::FIREWORK_ROCKET => throw new \Exception('To be implemented'),
            EntityType::FISHING_BOBBER => throw new \Exception('To be implemented'),
            EntityType::FOX => Fox::class,
            EntityType::FROG => Frog::class,
            EntityType::FURNACE_MINECART => throw new \Exception('To be implemented'),
            EntityType::GHAST => throw new \Exception('To be implemented'),
            EntityType::GIANT => throw new \Exception('To be implemented'),
            EntityType::GLOW_ITEM_FRAME => throw new \Exception('To be implemented'),
            EntityType::GLOW_SQUID => throw new \Exception('To be implemented'),
            EntityType::GOAT => Goat::class,
            EntityType::GUARDIAN => throw new \Exception('To be implemented'),
            EntityType::HOGLIN => Hoglin::class,
            EntityType::HOPPER_MINECART => throw new \Exception('To be implemented'),
            EntityType::HORSE => throw new \Exception('To be implemented'),
            EntityType::HUSK => throw new \Exception('To be implemented'),
            EntityType::ILLUSIONER => throw new \Exception('To be implemented'),
            EntityType::INTERACTION => throw new \Exception('To be implemented'),
            EntityType::IRON_GOLEM => throw new \Exception('To be implemented'),
            EntityType::ITEM => throw new \Exception('To be implemented'),
            EntityType::ITEM_DISPLAY => throw new \Exception('To be implemented'),
            EntityType::ITEM_FRAME => throw new \Exception('To be implemented'),
            EntityType::JUNGLE_BOAT => throw new \Exception('To be implemented'),
            EntityType::JUNGLE_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::LEASH_KNOT => throw new \Exception('To be implemented'),
            EntityType::LIGHTNING_BOLT => throw new \Exception('To be implemented'),
            EntityType::LINGERING_POTION => throw new \Exception('To be implemented'),
            EntityType::LLAMA => throw new \Exception('To be implemented'),
            EntityType::LLAMA_SPIT => throw new \Exception('To be implemented'),
            EntityType::MAGMA_CUBE => throw new \Exception('To be implemented'),
            EntityType::MANGROVE_BOAT => throw new \Exception('To be implemented'),
            EntityType::MANGROVE_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::MARKER => throw new \Exception('To be implemented'),
            EntityType::MINECART => throw new \Exception('To be implemented'),
            EntityType::MOOSHROOM => Mooshroom::class,
            EntityType::MULE => throw new \Exception('To be implemented'),
            EntityType::OAK_BOAT => throw new \Exception('To be implemented'),
            EntityType::OAK_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::OCELOT => Ocelot::class,
            EntityType::OMINOUS_ITEM_SPAWNER => throw new \Exception('To be implemented'),
            EntityType::PAINTING => throw new \Exception('To be implemented'),
            EntityType::PALE_OAK_BOAT => throw new \Exception('To be implemented'),
            EntityType::PALE_OAK_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::PANDA => Panda::class,
            EntityType::PARROT => throw new \Exception('To be implemented'),
            EntityType::PHANTOM => throw new \Exception('To be implemented'),
            EntityType::PIG => Pig::class,
            EntityType::PIGLIN => throw new \Exception('To be implemented'),
            EntityType::PIGLIN_BRUTE => throw new \Exception('To be implemented'),
            EntityType::PILLAGER => throw new \Exception('To be implemented'),
            EntityType::PLAYER => Player::class,
            EntityType::POLAR_BEAR => throw new \Exception('To be implemented'),
            EntityType::PUFFERFISH => throw new \Exception('To be implemented'),
            EntityType::RABBIT => Rabbit::class,
            EntityType::RAVAGER => throw new \Exception('To be implemented'),
            EntityType::SALMON => throw new \Exception('To be implemented'),
            EntityType::SHEEP => Sheep::class,
            EntityType::SHULKER => throw new \Exception('To be implemented'),
            EntityType::SHULKER_BULLET => throw new \Exception('To be implemented'),
            EntityType::SILVERFISH => throw new \Exception('To be implemented'),
            EntityType::SKELETON => throw new \Exception('To be implemented'),
            EntityType::SKELETON_HORSE => throw new \Exception('To be implemented'),
            EntityType::SLIME => throw new \Exception('To be implemented'),
            EntityType::SMALL_FIREBALL => throw new \Exception('To be implemented'),
            EntityType::SNIFFER => Sniffer::class,
            EntityType::SNOW_GOLEM => throw new \Exception('To be implemented'),
            EntityType::SNOWBALL => throw new \Exception('To be implemented'),
            EntityType::SPAWNER_MINECART => throw new \Exception('To be implemented'),
            EntityType::SPECTRAL_ARROW => throw new \Exception('To be implemented'),
            EntityType::SPIDER => throw new \Exception('To be implemented'),
            EntityType::SPLASH_POTION => throw new \Exception('To be implemented'),
            EntityType::SPRUCE_BOAT => throw new \Exception('To be implemented'),
            EntityType::SPRUCE_CHEST_BOAT => throw new \Exception('To be implemented'),
            EntityType::SQUID => throw new \Exception('To be implemented'),
            EntityType::STRAY => throw new \Exception('To be implemented'),
            EntityType::STRIDER => Strider::class,
            EntityType::TADPOLE => throw new \Exception('To be implemented'),
            EntityType::TEXT_DISPLAY => throw new \Exception('To be implemented'),
            EntityType::TNT => throw new \Exception('To be implemented'),
            EntityType::TNT_MINECART => throw new \Exception('To be implemented'),
            EntityType::TRADER_LLAMA => throw new \Exception('To be implemented'),
            EntityType::TRIDENT => throw new \Exception('To be implemented'),
            EntityType::TROPICAL_FISH => throw new \Exception('To be implemented'),
            EntityType::TURTLE => Turtle::class,
            EntityType::VEX => throw new \Exception('To be implemented'),
            EntityType::VILLAGER => throw new \Exception('To be implemented'),
            EntityType::VINDICATOR => throw new \Exception('To be implemented'),
            EntityType::WANDERING_TRADER => throw new \Exception('To be implemented'),
            EntityType::WARDEN => throw new \Exception('To be implemented'),
            EntityType::WIND_CHARGE => WindCharge::class,
            EntityType::WITCH => throw new \Exception('To be implemented'),
            EntityType::WITHER => throw new \Exception('To be implemented'),
            EntityType::WITHER_SKELETON => throw new \Exception('To be implemented'),
            EntityType::WITHER_SKULL => throw new \Exception('To be implemented'),
            EntityType::WOLF => throw new \Exception('To be implemented'),
            EntityType::ZOGLIN => throw new \Exception('To be implemented'),
            EntityType::ZOMBIE => throw new \Exception('To be implemented'),
            EntityType::ZOMBIE_HORSE => throw new \Exception('To be implemented'),
            EntityType::ZOMBIE_VILLAGER => throw new \Exception('To be implemented'),
            EntityType::ZOMBIFIED_PIGLIN => throw new \Exception('To be implemented'),
        };
    }
}
