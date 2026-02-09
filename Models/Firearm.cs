using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace Gunventory.Models;

public class Firearm
{
    public int Id { get; set; }
    [Required]
    [MaxLength(1)]
    public string Status { get; set; } = "A";
    [Required]
    [MaxLength(30)]
    public string Manufacturer { get; set; } = string.Empty;
    [Required]
    [MaxLength(50)]
    public string Model { get; set; } = string.Empty;
    public int GunTypeId { get; set; }
    public GunType GunType { get; set; } = null!;
    public int CaliberId { get; set; }
    public Caliber Caliber { get; set; } = null!;
    [Required]
    [MaxLength(20)]
    public string Serial { get; set; } = string.Empty;
    public DateTime PurchaseDate { get; set; }
    [Column(TypeName = "decimal(18, 2)")]
    public decimal Price { get; set; }
    [MaxLength(50)]
    public string? Notes { get; set; }
    [MaxLength(100)]
    public string? ImgURL { get; set; }
    [MaxLength(100)]
    public string? DocURL { get; set; }
    public DateTime STimestamp { get; set; } = DateTime.Now;

    public ICollection<ShootingActivity> ShootingActivities { get; set; } = new List<ShootingActivity>();
    public ICollection<Maintenance> MaintenanceRecords { get; set; } = new List<Maintenance>();
    public ICollection<Accessory> Accessories { get; set; } = new List<Accessory>();
    public ICollection<Malfunction> Malfunctions { get; set; } = new List<Malfunction>();
}
