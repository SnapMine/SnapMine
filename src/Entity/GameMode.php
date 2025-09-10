<?php

namespace SnapMine\Entity;

/**
 * Enumeration of player game modes.
 * 
 * Game modes determine how players can interact with the world,
 * their abilities, and what resources they have access to.
 * Each mode provides a different gameplay experience.
 * 
 * @package SnapMine\Entity
 * @author  Nirbose
 * @since   1.0.0
 */
enum GameMode: int
{
    /** 
     * Survival mode - players must gather resources and have health/hunger.
     * This is the default game mode with full survival mechanics.
     */
    case SURVIVAL = 0;
    
    /** 
     * Creative mode - players have unlimited resources and can fly.
     * Players cannot take damage and have access to all blocks/items.
     */
    case CREATIVE = 1;
    
    /** 
     * Adventure mode - players cannot break/place blocks without proper tools.
     * Designed for custom maps and adventure experiences.
     */
    case ADVENTURE = 2;
    
    /** 
     * Spectator mode - players can fly through blocks and observe without interaction.
     * Players are invisible and cannot interact with the world.
     */
    case SPECTATOR = 3;
}
