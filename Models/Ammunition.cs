using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace Gunventory.Models;

public class Ammunition
{
    public int Id { get; set; }
    [Required]
    [MaxLength(1)]
    public string Status { get; set; } = "A";
    [Required]
    [MaxLength(50)]
    public string Manufacturer { get; set; } = string.Empty;
    public int GunTypeId { get; set; }
    public GunType GunType { get; set; } = null!;
    public int CaliberId { get; set; }
    public Caliber Caliber { get; set; } = null!;
    public int Rounds { get; set; }
    public DateTime PurchaseDate { get; set; }
    [Column(TypeName = "decimal(9, 2)")]
    public decimal Price { get; set; }
    [MaxLength(100)]
    public string? ImgURL { get; set; }
    public DateTime STimestamp { get; set; } = DateTime.Now;
}
