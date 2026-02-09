using System.ComponentModel.DataAnnotations;

namespace Gunventory.Models;

public class Malfunction
{
    public int Id { get; set; }
    [Required]
    [MaxLength(1)]
    public string Status { get; set; } = "A";
    public int FirearmId { get; set; }
    public Firearm Firearm { get; set; } = null!;
    public int MalfunctionTypeId { get; set; }
    public MalfunctionType MalfunctionType { get; set; } = null!;
    public int AmmoId { get; set; }
    public Ammunition Ammunition { get; set; } = null!;
    public DateTime? MalfunctionDate { get; set; }
    [MaxLength(255)]
    public string? Details { get; set; }
    public DateTime STimestamp { get; set; } = DateTime.Now;
}
