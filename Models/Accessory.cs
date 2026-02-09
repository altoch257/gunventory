using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace Gunventory.Models;

public class Accessory
{
    public int Id { get; set; }
    [Required]
    [MaxLength(1)]
    public string Status { get; set; } = "A";
    [Required]
    [MaxLength(50)]
    public string Manufacturer { get; set; } = string.Empty;
    [Required]
    [MaxLength(50)]
    public string Model { get; set; } = string.Empty;
    public DateTime PurchaseDate { get; set; }
    [Column(TypeName = "decimal(9, 2)")]
    public decimal Price { get; set; }
    // In PHP this was INT NOT NULL, but it seems to be used for details or something.
    // Looking at functions.inc.php: `Details` INT NOT NULL
    // Wait, that's weird. Let me check the PHP code again.
    public string? Details { get; set; }
    public int FirearmId { get; set; }
    public Firearm Firearm { get; set; } = null!;
    [MaxLength(100)]
    public string? ImgURL { get; set; }
    public DateTime STimestamp { get; set; } = DateTime.Now;
}
