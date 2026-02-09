using System.ComponentModel.DataAnnotations;

namespace Gunventory.Models;

public class ShootingActivity
{
    public int Id { get; set; }
    [Required]
    [MaxLength(1)]
    public string Status { get; set; } = "A";
    public int FirearmId { get; set; }
    public Firearm Firearm { get; set; } = null!;
    public int AmmoId { get; set; }
    public Ammunition Ammunition { get; set; } = null!;
    public int CaliberId { get; set; }
    public Caliber Caliber { get; set; } = null!;
    public int ShootingTypeId { get; set; }
    public ShootingType ShootingType { get; set; } = null!;
    public DateTime ShootingDate { get; set; }
    public int RoundsFired { get; set; }
    public bool Subtract { get; set; } = false;
    [MaxLength(255)]
    public string? Details { get; set; }
    public DateTime STimestamp { get; set; } = DateTime.Now;
}
