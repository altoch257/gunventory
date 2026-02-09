using System.ComponentModel.DataAnnotations;

namespace Gunventory.Models;

public class Maintenance
{
    public int Id { get; set; }
    [Required]
    [MaxLength(1)]
    public string Status { get; set; } = "A";
    public int FirearmId { get; set; }
    public Firearm Firearm { get; set; } = null!;
    public int MaintenanceTypeId { get; set; }
    public MaintenanceType MaintenanceType { get; set; } = null!;
    public DateTime Date { get; set; }
    [MaxLength(255)]
    public string? Details { get; set; }
    public DateTime STimestamp { get; set; } = DateTime.Now;
}
