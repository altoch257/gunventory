using System.ComponentModel.DataAnnotations;

namespace Gunventory.Models;

public class User
{
    public int Id { get; set; }
    [Required]
    [MaxLength(1)]
    public string Status { get; set; } = "A";
    [Required]
    [MaxLength(50)]
    public string FirstName { get; set; } = string.Empty;
    [Required]
    [MaxLength(50)]
    public string LastName { get; set; } = string.Empty;
    [Required]
    [EmailAddress]
    [MaxLength(100)]
    public string Email { get; set; } = string.Empty;
    [MaxLength(15)]
    public string? Phone { get; set; }
    [Required]
    [MaxLength(20)]
    public string Username { get; set; } = string.Empty;
    [MaxLength(100)]
    public string? Password { get; set; }
    public int RoleId { get; set; }
    public Role Role { get; set; } = null!;
    [MaxLength(30)]
    public string? Position { get; set; }
    [MaxLength(30)]
    public string? Street { get; set; }
    [MaxLength(30)]
    public string? Street2 { get; set; }
    [MaxLength(30)]
    public string? City { get; set; }
    [MaxLength(2)]
    public string? State { get; set; }
    [MaxLength(10)]
    public string? Zip { get; set; }
    public DateTime STimestamp { get; set; } = DateTime.Now;
}
